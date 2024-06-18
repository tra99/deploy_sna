// ==========================================================>> Core Library
import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';

// ==========================================================>> Custom Library
import { ProductsModule } from 'app/main/product/product/product.module';

const productRoutes: Routes = [
    {
        path: '',
        children: [
            {
                path: 'all',
                loadChildren: () => import('app/main/product/product/product.module').then(m => m.ProductsModule)
            },
            {
                path: 'types',
                loadChildren: () => import('app/main/product/type/product-type.module').then(m => m.ProductTypeModule)
            },
            {
                path: 'brands',
                loadChildren: () => import('app/main/product/brand/product-brand.module').then(m => m.ProductBrandModule)
            },
            {
                path: 'categories',
                loadChildren: () => import('app/main/product/category/product-category.module').then(m => m.ProductCategoryModule)
            }
        ]
    },
];

@NgModule({
    imports: [
        RouterModule.forChild(productRoutes),
        ProductsModule
    ],
    exports: [
    ]
})
export class ProductModule{}
