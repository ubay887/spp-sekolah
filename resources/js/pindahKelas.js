import Vue from 'vue'
import axios from 'axios'


let Fire = new Vue();
window.Fire = Fire

new Vue({
    el: '#iseng',
    data: {
        simpanBtn: false,
        kelas_id: '',
        siswa: {},
    },
    watch: {
        //apabila nilai dari product > id berubah maka
        'kelas_id': function() {
            console.log('load data siswa berdasarkan kelas')
            this.getSiswa(this.kelas_id)
        },
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
        getSiswa(id){
            axios.get(`../kenaikanKelas/getSiswa?kelas_id=${id}`)
            .then((response) => {
                console.log(response.data)
                this.siswa = response.data
                //assign data yang diterima dari server ke buku
                // this.buku = response.data
            })
        }      

    },
    created() {

    },
})

