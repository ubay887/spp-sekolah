import Vue from 'vue'
import axios from 'axios'
import Autocomplete from '@trevoreyre/autocomplete-vue'
import '@trevoreyre/autocomplete-vue/dist/style.css'

Vue.use(Autocomplete)

let Fire = new Vue();
window.Fire = Fire


new Vue({
    el: '#iseng',
    data: {
        siswa: {},
        cart: {},
        cartTotal: '',
        tagihan: [],
        kelas: false,
        nama_kelas: [],
        dataSiswa: false,
        tagihan_id: '',
        submitCart: false,
        submit: [],
        showModal: false,
        showModalAngsuran: false,
        simpanBtn: false,
        tmp:{
            id: '',
            harga: '',
            jenis: '',
            sisa: '',
            keterangan: '',
        },
        showError: false,
        msgError: '',
        
    },
    watch: {
        'tmp.harga': function() {
            if(parseInt(this.tmp.harga) <= 10000){
                this.showError = true
                this.msgError = 'Minimal Pembayaran 10000'
            }else if(parseInt(this.tmp.harga) > parseInt(this.tmp.sisa)){
                this.showError = true
                this.msgError = `Jumlah bayar tidak boleh lebih dari Rp. ${this.tmp.sisa}`
            }else{
                this.showError = false
                this.msgError = ''
            }
        }
    },
    methods: {
        search(input) {
            const url = `../getSiswa?keyword=${input}`
            
            return new Promise(resolve => {
            if (input.length < 3) {
                return resolve([])
            }
    
            fetch(url)
                .then(response => response.json())
                .then(data => {
                    resolve(data)
                })
            })
        },
        getResultValue(result) {
            return `[${result.nis}] ${result.nama_lengkap} ${result.kelas.nama_kelas}`
        },
        handleSubmit(result) {
            
            this.dataSiswa = true
            this.siswa = result
            this.getTagihan(result.id)
            this.removeAllCart()
            
        },
        getTagihan(id) {
            axios.get(`../getTagihan/${id}`)
            .then((response) => {
                // console.log(response.data)
                this.tagihan = response.data
                
            })
        },
        addToCart(id, harga, jenis, keterangan, tipe){
            // console.log(tipe)
            this.submit[id] = true

            this.submitCart = true
            this.tagihan_id = id
            axios.get(`../cart/addCart?id=${id}&jenis=${jenis}&harga=${harga}&keterangan=${keterangan}`)
            .then((res) => {
                Fire.$emit('afterAddCart')
                // console.log(res)
                this.submitCart = false
            })
            .catch((err) => {
                console.log(err)
            })
        },
        getCart() {
            axios.get(`../cart`)
            .then((res) => {
                this.cart = res.data.cartItems
                this.cartTotal = res.data.cartTotal
                // console.log(this.cartTotal)
            })
            .catch((err) => {
                console.log(err)
            })
        },
        deleteItem(rowId, id){
            console.log(id)
            this.submitCart = true
            axios.delete(`../cart/deleteItem/${rowId}`)
            .then((res) => {
                // console.log(res)
                Fire.$emit('afterAddCart')
                
                this.submitCart = false
                this.submit[id] = false
            })
            .catch((err) => {
                console.log(err)
            })
        },
        removeAllCart(){
            axios.get(`../cart/removeCart`)
            .then((response) => {
                // console.log(response)
                this.cart = {}
                this.submit = []
                Fire.$emit('afterAddCart')
            })
        },
        bayarAngsuran(id, harga, jenis, keterangan){
            this.showModalAngsuran = true;
            this.showError = false

            this.tmp.id = id
            this.tmp.harga = harga
            this.tmp.sisa = harga
            this.tmp.jenis = jenis
            this.tmp.keterangan = keterangan
            
        },      
        bayarAngsuranSubmit(){
            if(parseInt(this.tmp.harga) <= 10000){
                this.showError = true
                return
            }
            if(parseInt(this.tmp.harga) > parseInt(this.tmp.sisa)){
                this.showError = true
                return
            }
            this.showModalAngsuran = false;
            this.addToCart(this.tmp.id, this.tmp.harga, this.tmp.jenis, this.tmp.keterangan, 1)
        },      
        storePembayaran(siswaId){
            console.log('store pembayaran')
            this.simpanBtn = true
            // url = 'http://localhost:8000/'
            axios.get(`../cartSimpan?siswaId=${siswaId}`)
            .then((res) => {
                // console.log(res)
                Fire.$emit('afterAddCart')
                this.showModal = false
                this.simpanBtn = false
                iziToast.success({
                    title: '',
                    message: 'Pembayaran Berhasil!',
                    position: 'bottomCenter'
                });
                this.submit[this.tmp.id] = false
                this.getTagihan(siswaId)
            })
            .catch((err) => {
                console.log(err)
            })
        },      

    },
    created() {
        this.getCart()

        Fire.$on('afterAddCart', () => {
            this.getCart()
        })
    },
})

