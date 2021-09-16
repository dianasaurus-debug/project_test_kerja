<template>
    <div>
        <div class="col-12 mt-3">
            <div class="card">
                <div class="card-header border-0">
                    <h3 class="card-title">Data Gedung</h3>
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
                                     <a href="#" class="mr-2" @click="viewGedung(props.row.id)">
                                    <i class="fas fa-eye" style="color : red !important;"></i>
                                </a>
                                  <a href="#" class="mr-2" @click="editModal(props.row)">
                                    <i class="fas fa-user-edit" style="color : lightseagreen !important;"></i>
                                    </a>
                                    <a href="#" @click="deleteGedung(props.row.id)">
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
                        <h5 class="modal-title" v-show="!editmode">Tambah Data Gedung</h5>
                        <h5 class="modal-title" v-show="editmode">Edit Data Gedung</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" style="color : red">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="editmode ? updateGedung() : createGedung()">
                        <div class="modal-body">
                            <div class="form-group">
                                <input v-model="form.nama_gedung" type="text" name="nama_gedung"
                                       class="form-control" :class="{ 'is-invalid': form.errors.has('nama_gedung') }"
                                       placeholder="Nama Gedung">
                                <has-error :form="form" field="nama_gedung"></has-error>
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
                                <select class="form-control" id="choose_campus" name="campus_id" v-model="form.campus_id">
                                    <option value="" disabled selected>Tempat Kampus</option>
                                    <option v-for="kampus in campus" v-bind:value="kampus.id">{{ kampus.nama_kampus }}</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <select class="form-control" id="choose_kondisi" name="kondisi_gedung" v-model="form.kondisi_gedung">
                                    <option value="" disabled selected>Pilih Kondisi Gedung</option>
                                    <option v-for="k in kondisi" v-bind:value="k">{{ k }}</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Foto Gedung</label>
                                <img id="diplay_img" v-bind:src="imagePreview" style="border-radius : 5px;max-height : 120px; max-width: 130px;"/><hr/>
                                <input type="file" name="foto_gedung" class="form-control-file" id="picture" @change="onFileChange">
                                <has-error :form="form" field="foto_gedung"></has-error>
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
                        <h5 class="modal-title">View Data Gedung</h5>
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
                                        <th scope="col">Nama Gedung</th>
                                        <th scope="col">Deskripsi</th>
                                        <th scope="col">Tanggal Dibangun</th>
                                        <th scope="col">Tempat Kampus</th>
                                        <th scope="col">Kondisi Gedung</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <th>{{gedung.nama_gedung}}</th>
                                        <td>{{gedung.deskripsi}}</td>
                                        <td>{{gedung.tanggal_dibangun}}</td>
                                        <td>{{gedung.kampus}}</td>
                                        <td>{{gedung.kondisi_gedung}}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                Foto Gedung<br>
                                <img class="img-thumbnail" :src="'/images/gedung/'+gedung.foto_gedung" style="width:200px">
                            </div>
                            <div class="col-6">
                                Daftar Ruang<br>
                                <ul id="example-1" v-if="gedung.rooms != undefined">
                                    <li v-for="room in gedung.rooms" :key="room.id">
                                        {{ room.nama_ruang }}
                                    </li>
                                </ul>
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
                    {label: 'Nama Gedung', field: 'nama_gedung'},
                    {label: 'Kondisi Gedung', field: 'kondisi_gedung'},
                    {label: 'Kampus', field: 'kampus'},
                    {label: 'Tanggal Dibangun', field: 'tanggal_dibangun'},
                    {label: 'Action', field: 'action'}
                ],
                rows: [],
                campus : [],
                page: 1,
                per_page: 10,
                gedung : {},
                kondisi : ['Baik', 'Sedang direnovasi', 'Perlu direnovasi'],
                editmode : false,
                form: new Form({
                    id : '',
                    nama_gedung: '',
                    kondisi_gedung: '',
                    campus_id: '',
                    deskripsi:'',
                    tanggal_dibangun:'',
                    foto_gedung: '',
                }),
                imagePreview: '/images/image_placeholder.png',
            }
        },
        methods:{
            viewGedung(id){
                this.loading = true;
                axios.get('/api/gedung/'+id).then( response => {
                    this.gedung = response.data;
                });
                $("#viewData").modal('show');
            },
            getGedung() {
                axios.get('/api/gedung').then(function(response){
                    this.rows = response.data.data;
                }.bind(this));
            },
            getKampus() {
                axios.get('/api/kampus').then(function(response){
                    this.campus = response.data.data;
                }.bind(this));
            },
            newModal() {
                this.imagePreview='/images/image_placeholder.png';
                this.form.reset();
                this.editmode = false;
                $("#addNew").modal('show');
            },
            editModal(gedung) {
                this.form.reset();
                this.editmode = true;
                this.form.fill(gedung);
                this.imagePreview = '/images/gedung/'+gedung.foto_gedung;
                $("#addNew").modal('show');
            },
            createGedung() {
                const config = {
                    headers: { 'content-type': 'multipart/form-data' }
                }
                let formData = new FormData();

                formData.append("nama_gedung", this.form.nama_gedung);
                formData.append("deskripsi", this.form.deskripsi);
                formData.append("kondisi_gedung", this.form.kondisi_gedung);
                formData.append("campus_id", this.form.campus_id);
                formData.append("tanggal_dibangun", this.form.tanggal_dibangun);
                formData.append("foto_gedung", this.form.foto_gedung);

                this.$Progress.start();
                axios.post('/api/gedung', formData, config).then( () => {
                    Fire.$emit('AfterCreated');
                    $("#addNew").modal('hide');
                    $('body').removeClass('modal-open');
                    $('.modal-backdrop').remove();
                    toast.fire({
                        icon: 'success',
                        title: 'Data Gedung sudah ditambahkan!'
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
            deleteGedung(id) {
                swal.fire({
                    title: 'Anda yakin?',
                    text: "Tindakan ini tidak bisa menghapus data ruang yang mengacu padanya!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Iya, hapus saja!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.form.delete('/api/gedung/' + id).then(() => {
                            Fire.$emit('AfterCreated');
                            swal.fire(
                                'Deleted!',
                                'Data Gedung sudah dihapus',
                                'success'
                            )
                        });
                    }
                })
            },
            updateGedung() {
                this.$Progress.start();
                const config = {
                    headers: { 'content-type': 'multipart/form-data' }
                }
                let formData = new FormData();
                formData.append("nama_gedung", this.form.nama_gedung);
                formData.append("deskripsi", this.form.deskripsi);
                formData.append("kondisi_gedung", this.form.kondisi_gedung);
                formData.append("campus_id", this.form.campus_id);
                formData.append("tanggal_dibangun", this.form.tanggal_dibangun);
                formData.append("foto_gedung", this.form.foto_gedung);
                formData.append("_method", 'PATCH');
                axios.post('/api/gedung/' + this.form.id, formData, config).then(() => {
                    Fire.$emit('AfterCreated');
                    $("#addNew").modal('hide');
                    swal.fire(
                        'Updated!',
                        'Data gedung sudah diupdate',
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
                this.form.foto_gedung = event.target.files[0];

                let reader  = new FileReader();

                reader.addEventListener("load", function () {
                    this.imagePreview = reader.result;
                }.bind(this), false);

                if( this.form.foto_gedung ){
                    if ( /\.(jpe?g|jpg|png|gif)$/i.test( this.form.foto_gedung.name ) ) {

                        console.log("here");
                        reader.readAsDataURL( this.form.foto_gedung );
                    }
                }
            },

        },
        created: function(){
            this.getGedung();
            this.getKampus();
            Fire.$on('AfterCreated', () => {
                this.getGedung();
            })
        }
    }
</script>
