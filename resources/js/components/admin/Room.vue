<template>
    <div>
        <div class="col-12 mt-3">
            <div class="card">
                <div class="card-header border-0">
                    <h3 class="card-title">Data Ruangan</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-success"@click="newModal">
                            Tambah  <i class="fas fa-user-plus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body table-responsive p-0">
                    <vue-good-table
                        :columns="columns"
                        :rows="rows"
                        :search-options="{ enabled: true }"
                        :pagination-options="{enabled: true}"
                        :line-numbers="true">
                        <template slot="table-row" slot-scope="props">
                                <span v-if="props.column.field == 'action'">
                                     <a href="#" class="mr-2" @click="viewRuang(props.row.id)">
                                    <i class="fas fa-eye" style="color : red !important;"></i>
                                </a>
                                  <a href="#" class="mr-2" @click="editModal(props.row)">
                                    <i class="fas fa-user-edit" style="color : lightseagreen !important;"></i>
                                    </a>
                                    <a href="#" @click="deleteRuang(props.row.id)">
                                        <i class="fas fa-trash" style="color : red !important;"></i>
                                    </a>
                                </span>
                            <span v-else>
                                  {{props.formattedRow[props.column.field]}}
                                </span>
                        </template>
                    </vue-good-table>
                </div>
            </div>
            <!-- /.card -->
        </div>

        <!-- Modal Add|edit -->
        <div class="modal fade" id="addNew" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" v-show="!editmode">Tambah Data Ruangan</h5>
                        <h5 class="modal-title" v-show="editmode">Edit Data Ruangan</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" style="color : red">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="editmode ? updateRuang() : createRuang()">
                        <div class="modal-body">
                            <div class="form-group">
                                <input v-model="form.nama_ruang" type="text" name="nama_ruang"
                                       class="form-control" :class="{ 'is-invalid': form.errors.has('nama_ruang') }"
                                       placeholder="Nama ruang">
                                <has-error :form="form" field="nama_ruang"></has-error>
                            </div>
                            <div class="form-group">
                                <textarea v-model="form.deskripsi" type="text" name="deskripsi"
                                          class="form-control" :class="{ 'is-invalid': form.errors.has('deskripsi') }"
                                          placeholder="Deskripsi..."></textarea>
                                <has-error :form="form" field="deskripsi"></has-error>
                            </div>
                            <div class="form-group">
                                <label>Tanggal Dibangun</label>
                                <input v-model="form.tanggal_dibangun" type="date" name="tanggal_dibangun"
                                       class="form-control" :class="{ 'is-invalid': form.errors.has('tanggal_dibangun') }"
                                       placeholder="Tanggal Dibangun">
                                <has-error :form="form" field="tanggal_dibangun"></has-error>
                            </div>
                            <div class="form-group">
                                <select class="form-control" id="choose_gedung" name="gedung_id" v-model="form.gedung_id">
                                    <option value="" disabled selected>Tempat Gedung</option>
                                    <option v-for="gedung in allGedung" v-bind:value="gedung.id">{{ gedung.nama_gedung }}</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <select class="form-control" id="choose_kondisi" name="kondisi_ruang" v-model="form.kondisi_ruang">
                                    <option value="" disabled selected>Pilih Kondisi ruang</option>
                                    <option v-for="k in kondisi" v-bind:value="k">{{ k }}</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Foto ruang</label>
                                <img id="diplay_img" v-bind:src="imagePreview" style="border-radius : 5px;max-height : 120px; max-width: 130px;"/><hr/>
                                <input type="file" name="foto_ruang" class="form-control-file" id="picture" @change="onFileChange">
                                <has-error :form="form" field="foto_ruang"></has-error>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal View -->
        <div class="modal fade" id="viewData" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">View Data ruang</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" style="color : red">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th scope="col">Nama ruang</th>
                                        <th scope="col">Kondisi Ruang</th>
                                        <th scope="col">Tanggal Dibangun</th>
                                        <th scope="col">Tempat Gedung</th>
                                        <th scope="col">Deskripsi</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <th>{{ruang.nama_ruang}}</th>
                                        <td>{{ruang.kondisi_ruang}}</td>
                                        <td>{{ruang.tanggal_dibangun}}</td>
                                        <td>{{ruang.gedung}}</td>
                                        <td>{{ruang.deskripsi}}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                Foto ruang<br>
                                <img class="img-thumbnail" :src="'/images/ruang/'+ruang.foto_ruang" style="width:200px">
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
export default {
    mounted() {
        console.log('Component mounted.')
    },
    data(){
        return {
            columns: [
                {label: 'id', field: 'id'},
                {label: 'Nama Ruang', field: 'nama_ruang'},
                {label: 'Kondisi Ruang', field: 'kondisi_ruang'},
                {label: 'Gedung', field: 'gedung'},
                {label: 'Tanggal Dibangun', field: 'tanggal_dibangun'},
                {label: 'Action', field: 'action'}
            ],
            rows: [],
            allGedung : [],
            page: 1,
            ruang : {},
            per_page: 10,
            kondisi : ['Baik', 'Sedang direnovasi', 'Perlu direnovasi'],
            editmode : false,
            form: new Form({
                id : '',
                nama_ruang: '',
                kondisi_ruang: '',
                gedung_id: '',
                deskripsi:'',
                tanggal_dibangun:'',
                foto_ruang: '',
            }),
            imagePreview: '/images/image_placeholder.png',
        }
    },
    methods:{
        viewRuang(id){
            this.loading = true;
            axios.get('/api/ruang/'+id).then( response => {
                this.ruang = response.data;
            });
            $("#viewData").modal('show');
        },
        getRuang() {
            axios.get('/api/ruang').then(function(response){
                this.rows = response.data.data;
            }.bind(this));
        },
        getGedung() {
            axios.get('/api/gedung').then(function(response){
                this.allGedung = response.data.data;
            }.bind(this));
        },
        newModal() {
            this.imagePreview= '/images/image_placeholder.png';
            this.form.reset();
            this.editmode = false;
            $("#addNew").modal('show');
        },
        editModal(ruang) {
            this.form.reset();
            this.editmode = true;
            this.form.fill(ruang);
            this.imagePreview = '/images/ruang/'+ruang.foto_ruang;
            $("#addNew").modal('show');
        },
        createRuang() {
            const config = {
                headers: { 'content-type': 'multipart/form-data' }
            }
            let formData = new FormData();

            formData.append("nama_ruang", this.form.nama_ruang);
            formData.append("deskripsi", this.form.deskripsi);
            formData.append("kondisi_ruang", this.form.kondisi_ruang);
            formData.append("gedung_id", this.form.gedung_id);
            formData.append("tanggal_dibangun", this.form.tanggal_dibangun);
            formData.append("foto_ruang", this.form.foto_ruang);

            this.$Progress.start();
            axios.post('/api/ruang', formData, config).then( () => {
                Fire.$emit('AfterCreated');
                $("#addNew").modal('hide');
                $('body').removeClass('modal-open');
                $('.modal-backdrop').remove();
                toast.fire({
                    icon: 'success',
                    title: 'Data ruang sudah ditambahkan!'
                })
                this.$Progress.finish();
            })
                .catch( () => {
                    this.$Progress.fail();
                    swal.fire(
                        'Not Created!',
                        'Pastikan anda mengisikan data dengan benar',
                        'error'
                    )
                });
        },
        deleteRuang(id) {
            swal.fire({
                title: 'Anda yakin?',
                text: "Tindakan ini tidak bisa dibalikkan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Iya, hapus saja!'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.form.delete('/api/ruang/' + id).then(() => {
                        Fire.$emit('AfterCreated');
                        swal.fire(
                            'Deleted!',
                            'Data ruang sudah dihapus',
                            'success'
                        )
                    });
                }
            })
        },
        updateRuang() {
            this.$Progress.start();
            const config = {
                headers: { 'content-type': 'multipart/form-data' }
            }
            let formData = new FormData();
            formData.append("nama_ruang", this.form.nama_ruang);
            formData.append("deskripsi", this.form.deskripsi);
            formData.append("kondisi_ruang", this.form.kondisi_ruang);
            formData.append("gedung_id", this.form.gedung_id);
            formData.append("tanggal_dibangun", this.form.tanggal_dibangun);
            formData.append("foto_ruang", this.form.foto_ruang);
            formData.append("_method", 'PATCH');
            axios.post('/api/ruang/' + this.form.id, formData, config).then(() => {
                Fire.$emit('AfterCreated');
                $("#addNew").modal('hide');
                swal.fire(
                    'Updated!',
                    'Data ruang sudah diupdate',
                    'success'
                )
                this.$Progress.finish();
            })
                .catch(() => {
                    console.log(formData);
                    this.$Progress.fail();
                    swal.fire(
                        'Not Updated!',
                        'Pastikan anda mengisikan data dengan benar',
                        'error'
                    )
                });
        },
        onFileChange(event){
            this.form.foto_ruang = event.target.files[0];

            let reader  = new FileReader();

            reader.addEventListener("load", function () {
                this.imagePreview = reader.result;
            }.bind(this), false);

            if( this.form.foto_ruang ){
                if ( /\.(jpe?g|jpg|png|gif)$/i.test( this.form.foto_ruang.name ) ) {

                    console.log("here");
                    reader.readAsDataURL( this.form.foto_ruang );
                }
            }
        },

    },
    created: function(){
        this.getRuang();
        this.getGedung();
        Fire.$on('AfterCreated', () => {
            this.getRuang();
        })
    }
}
</script>
