// ==========================================================>> Custom Library
import { NavigationItem } from 'helpers/components/navigation';
let isAdmin = true;

export const defaultNavigation: NavigationItem[] = [
    //===================================>> Dashboard
    {
        id: 'dashboard',
        title: 'ផ្ទាំងព័ត៌មាន',
        type: 'basic',
        icon: 'mat_outline:dashboard',
        link: '/dashboard',
    },
    //===================================>> POS
    {
        id: 'pos',
        title: 'ការបញ្ជាទិញ',
        type: 'basic',
        icon: 'mat_solid:desktop_mac',
        link: '/pos',
    },
    //===================================>> Sale
    {
        id: 'sale',
        title: 'ការលក់',
        type: 'basic',
        icon: 'mat_solid:shopping_cart',
        link: '/sales',
    },
    //===================================>> Product
    {
        hidden() {
            isAdmin = true;
            if (localStorage.getItem('role') == 'Admin') {
                isAdmin = false;
            }
            return isAdmin;
        },
        id: 'product',
        title: 'ផលិតផល',
        type: 'collapsable',
        icon: 'mat_solid:shop_two',
        children: [
            {
                id: 'all-product',
                title: 'ផលិតផលទាំងអស់',
                type: 'basic',
                icon: 'heroicons_solid:chevron-right',
                link: 'product/all',
            },
            {
                id: 'product-type',
                title: 'ប្រភេទផលិតផល',
                type: 'basic',
                icon: 'heroicons_solid:chevron-right',
                link: 'product/types',
            },
            {
                id: 'product-brand',
                title: 'ម៉ាកផលិតផល',
                type: 'basic',
                icon: 'heroicons_solid:chevron-right',
                link: 'product/brands',
            },
            {
                id: 'product-category',
                title: 'ក្រុមផលិតផល',
                type: 'basic',
                icon: 'heroicons_solid:chevron-right',
                link: 'product/categories',
            },
        ],
    },
    //===================================>> Customer
    {
        hidden() {
            isAdmin = true;
            if (localStorage.getItem('role') == 'Admin') {
                isAdmin = false;
            }
            return isAdmin;
        },
        id: 'customer',
        title: 'អតិថិជន',
        type: 'basic',
        icon: 'mat_outline:people',
        link: '/customers',
    },
    // {
    //     hidden() {
    //         isAdmin = true;
    //         if(localStorage.getItem('role') == 'Admin'){
    //             isAdmin = false;
    //         }
    //         return isAdmin;
    //     },
    //     id       : 'Customer',
    //     title    : 'អតិថិជន',
    //     type     : 'collapsable',
    //     icon     : 'mat_solid:shop_two',
    //     children : [
    //         {
    //             id       : 'all-customer',
    //             title    : 'អតិថិជនទាំងអស់',
    //             type     : 'basic',
    //             icon     : 'heroicons_solid:chevron-right',
    //             link     : 'customer/all'
    //         }
    //     ],
    // },
    //===========================================>>User
    {
        hidden() {
            isAdmin = true;
            if (localStorage.getItem('role') == 'Admin') {
                isAdmin = false;
            }
            return isAdmin;
        },
        id: 'user',
        title: 'អ្នកប្រើប្រាស់',
        type: 'basic',
        icon: 'mat_outline:people',
        link: '/users',
    },
    {
        id: 'profile',
        title: 'គណនី',
        type: 'basic',
        icon: 'mat_outline:person',
        link: '/my-profile',
    },
];
