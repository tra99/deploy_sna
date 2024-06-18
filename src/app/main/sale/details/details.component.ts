// ==========================================================>> Core Library
import { Component, Inject, OnInit } from '@angular/core';

// ==========================================================>> Third Party Library
import { MatDialogRef, MAT_DIALOG_DATA } from '@angular/material/dialog';
import { MatTableDataSource } from '@angular/material/table';


// ==========================================================>> Custom Library
import { SnackbarService } from 'app/shared/services/snackbar.service';
import { SaleService } from '../sale.service';
import * as FileSaver from 'file-saver';


@Component({
  selector: 'app-details',
  templateUrl: './details.component.html',
  styleUrls: ['./details.component.scss']
})
export class DetailsComponent implements OnInit {

  public displayedColumns: string[] = ['no', 'product', 'price', 'qty', 'total'];
  public dataSource: any;
  public downloading: boolean = false;
  public status_id: number = 0;
  public item: any[];
  constructor(
    @Inject(MAT_DIALOG_DATA) public data: any,
    private _dialogRef: MatDialogRef<DetailsComponent>,
    private _saleService: SaleService,
    private _snackBar: SnackbarService,
  ) {
    this._dialogRef.disableClose = true;
  }

  ngOnInit(): void {
    this.dataSource = new MatTableDataSource(this.data.details);
  }

  print(): void {
    this.downloading = true;
    this._saleService.print(this.data.receipt_number).subscribe((res: any) => {
      this.downloading = false;
      let blob = this._saleService.b64toBlob(res.file_base64, 'application/pdf', '');
      FileSaver.saveAs(blob, 'Invoice-' + this.data.receipt_number + '.pdf');
    }, (err: any) => {
      this.downloading = false;
    });
  }

  // ========== take action ============= \\
  takeAction( action:number = 1 ): void {
    this._saleService.takeAction(this.data.id, action).subscribe((res: any) => {

        //Display SnackBar Message
        this._snackBar.openSnackBar(res.message , '');

        //Close dialog
        this._dialogRef.close(res.data);


    }, (err: any) => {
        console.log(err);

        //Display SnackBar Message
        this._snackBar.openSnackBar(err.error.message , 'error');

    });
  }


  // =================================>> Convert base64 to blob
  // b64toBlob(b64Data: any, contentType: any, sliceSize: any) {
  //   contentType = contentType || '';
  //   sliceSize = sliceSize || 512;
  //   var byteCharacters = atob(b64Data);
  //   var byteArrays = [];
  //   for (var offset = 0; offset < byteCharacters.length; offset += sliceSize) {
  //     var slice = byteCharacters.slice(offset, offset + sliceSize);
  //     var byteNumbers = new Array(slice.length);
  //     for (var i = 0; i < slice.length; i++) {
  //       byteNumbers[i] = slice.charCodeAt(i);
  //     }
  //     var byteArray = new Uint8Array(byteNumbers);
  //     byteArrays.push(byteArray);
  //   }
  //   var blob = new Blob(byteArrays, { type: contentType });
  //   return blob;
  // }

}
