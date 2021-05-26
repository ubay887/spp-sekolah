import Vue from 'vue'
import axios from 'axios'

// import VueSweetalert2 from 'vue-sweetalert2';

// import VueSweetalert2 from 'vue-sweetalert2';
// import 'sweetalert2/dist/sweetalert2.min.css';

// Vue.filter('currency', function (money) {
//     return accounting.formatMoney(money, "Rp ", 2, ".", ",")
// })

// //use sweetalert
// Vue.use(VueSweetalert2);

new Vue({
    el: '#iseng',
    data: {
        val: {
            nama_pembayaran: false,
            qty: '',
            harga: '',
            judul: '',
            cover: ''
        },
        pelanggan: {
            id: '',
            nama_pelanggan: '',
            emal: '',
            no_telpon: '',
        },
        cart: {
            buku_id: '',
            qty: 1,
        },
        submitCart: false,
        shoppingCart: [],
        subTotal: 0,
        submitForm: false,
        message: '',
        url: '',
        tagihan: '',
        kelas: false,
        nama_kelas: [],
        
        
    },
    watch: {
        //apabila nilai dari product > id berubah maka
        // 'buku.id': function() {
        //     //mengecek jika nilai dari buku > id ada
        //     if (this.buku.id) {
        //         //maka akan menjalankan methods getBuku
        //         this.getBuku()
        //     }
        // },
        // 'pelanggan.id': function() {
        //     if (this.pelanggan.id) {
        //         this.getPelanggan()
        //     }
        // }
        'tagihan': function(){
            if(this.tagihan == "kelas"){
                this.kelas = true
            }else{
                this.kelas = false
            }
            console.log(this.tagihan)
        }

    },
    //menggunakan library select2 ketika file ini di-load
    mounted() {
        //memanggil method getCart() untuk me-load cookie cart
        // this.getCart()
    },
    methods: {
        getBuku() {
            //fetch ke server menggunakan axios dengan mengirimkan parameter id
            //dengan url /api/product/{id}
            axios.get(`/api/buku/${this.buku.id}`)
            .then((response) => {
                //assign data yang diterima dari server ke buku
                this.buku = response.data
            })
        },

        // getPelanggan() {
        //     axios.get(`/api/pelanggan/${this.pelanggan.id}`)
        //     .then((response) => {
        //         this.pelanggan = response.data
        //         console.log(this.pelanggan.email)
        //     })
        // },
        
        //  //method untuk menambahkan product yang dipilih ke dalam cart
        //  addToCart() {
        //     this.submitCart = true
        //     this.cart.buku_id = this.buku.id
        //     let t;
        //     t = this.buku.stok - this.cart.qty

        //     if(t < 0){
        //         this.notifikasi('exclamation', 'Warning', 'Stok Tidak Mencukupi', 'warning')
        //         this.submitCart = false
        //         return

        //     }
        //     //send data ke server
        //     axios.post('/api/cart', this.cart)
        //     .then((response) => {
        //         console.log(response)
        //         setTimeout(() => {
        //             //apabila berhasil, data disimpan ke dalam var shoppingCart
        //             this.getCart()
                    
        //             //mengosongkan var
        //             this.cart.buku_id = ''
        //             this.cart.qty = 1
        //             this.buku = {
        //                 id: '',
        //                 qty: '',
        //                 harga: '',
        //                 judul: '',
        //                 cover: ''
        //             }
        //             this.submitCart = false
        //             this.notifikasi('success', 'Success', 'Item Berhasil Ditambahkan Ke Keranjang Belanja', 'success')
        //         }, 1000)
                
        //     })
        //     .catch((error) => {
        //         this.notifikasi('exclamation', 'Warning', 'Silahkan Pilih Item Terlebih Dahulu!', 'warning')
                
        //         this.submitCart = false
        //     })
        // },

        // //mengambil list cart yang telah disimpan
        // getCart() {
        //     //fetch data ke server
        //     axios.get('/api/cart')
        //     .then((response) => {
        //         //data yang diterima disimpan ke dalam var shoppingCart
        //         this.shoppingCart = response.data.items
        //         this.subTotal = response.data.total
        //     })
        // },

        // //menghapus cart
        // removeCart(id) {
        //     //menampilkan konfirmasi dengan sweetalert
        //     this.$swal({
        //         title: 'Kamu Yakin?',
        //         text: 'Kamu Tidak Dapat Mengembalikan Tindakan Ini!',
        //         type: 'warning',
        //         showCancelButton: true,
        //         confirmButtonText: 'Iya, Lanjutkan!',
        //         cancelButtonText: 'Tidak, Batalkan!',
        //         showCloseButton: true,
        //         showLoaderOnConfirm: true,
        //         preConfirm: () => {
        //             return new Promise((resolve) => {
        //                 setTimeout(() => {
        //                     resolve()
        //                 }, 2000)
        //             })
        //         },
        //         allowOutsideClick: () => !this.$swal.isLoading()
        //     }).then ((result) => {
        //         //apabila disetujui
        //         if (result.value) {
        //             //kirim data ke server
        //             axios.delete(`/api/cart/${id}`)
        //             .then ((response) => {
        //                 //load cart yang baru
        //                 this.getCart();
        //                 this.notifikasi('success', 'Success', 'Item Berhasil Dihapus dari keranjang Belanja', 'success')
        //             })
        //             .catch ((error) => {
        //                 console.log(error);
        //             })
        //         }
        //     })
        // },

        // sendOrder() {
        //     //Mengosongkan var errorMessage dan message
        //     // this.errorMessage = ''
        //     // this.message = ''
            
        //     //jika var customer.email dan kawan-kawannya tidak kosong
        //     if (this.pelanggan.id != '') {
        //         console.log('simpan transaksi')
        //         //maka akan menampilkan kotak dialog konfirmasi
        //         this.$swal({
        //             title: 'Kamu Yakin?',
        //             text: 'Kamu Tidak Dapat Mengembalikan Tindakan Ini!',
        //             type: 'warning',
        //             showCancelButton: true,
        //             confirmButtonText: 'Iya, Lanjutkan!',
        //             cancelButtonText: 'Tidak, Batalkan!',
        //             showCloseButton: true,
        //             showLoaderOnConfirm: true,
        //             preConfirm: () => {
        //                 return new Promise((resolve) => {
        //                     setTimeout(() => {
        //                         resolve()
        //                     }, 2000)
        //                 })
        //             },
        //             allowOutsideClick: () => !this.$swal.isLoading()
        //         }).then ((result) => {
        //             //jika di setujui
        //             if (result.value) {
        //                 //maka submitForm akan di-set menjadi true sehingga menciptakan efek loading
        //                 this.submitForm = true
        //                 //mengirimkan data dengan uri /checkout
        //                 axios.post('/checkout', this.pelanggan)
        //                 .then((response) => {
        //                     setTimeout(() => {
        //                         //jika responsenya berhasil, maka cart di-reload
        //                         this.getCart();
        //                         this.notifikasi('success', 'Success', 'Transaksi berhasil disimpan', 'success')
                                
        //                         //message di-set untuk ditampilkan
        //                         this.message = response.data.message
        //                         this.url = `/penjualan/pdf/${this.message}`
        //                         //form customer dikosongkan
        //                         this.pelanggan = {
        //                             nama_pelanggan: '',
        //                             no_telpon: '',
        //                             alamat: ''
        //                         }
        //                         //submitForm kembali di-set menjadi false
        //                         this.submitForm = false
                                
        //                     }, 1000)

                            
        //                 })
        //                 .catch((error) => {
        //                     console.log(error)
        //                 })
        //             }
        //         })
        //     } else {
        //         this.notifikasi('exclamation', 'Warning', 'Silahkan Pilih Pelanggan', 'warning')
        //     }
        // },
        
        // notifikasi(icon, title, message, type) {
        //     $.notify({
        //         icon: `flaticon-${icon}`,
        //         title: title,
        //         message: message,
        //     },{
        //         type: type,
        //         placement: {
        //             from: "top",
        //             align: "right"
        //         },
        //         time: 1000,
        //     });
        // },

    },
    computed: {
        // total: function () {
        //     return this.subTotal

        //     // this.shoppingCart.forEach(e => {
        //     //     sum += e.subtotal;
        //     // });
        //     // console.log(this.shoppingCart);
        //     // Object.values(this.shoppingCart).forEach((val, index) => {
        //     //     console.log(val.harga)
        //     //     sum += val.harga;
        //     //     this.subTotal = sum
        //     // })
        //     // // for (const item in this.shoppingCart) {
        //     // //     sum += item.harga;
        //     // //     console.log(`obj.${item}`)
        //     // //   }
        //     // //   console.log(sum);
        //     // console.log(this.subTotal);
        //     // return this.subTotal
        // }
    }
})