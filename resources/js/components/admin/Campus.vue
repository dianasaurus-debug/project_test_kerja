<template>
    <div>
        <div class="col-12 mt-3">
            <div class="card">
                <div class="card-header border-0">
                    <h3 class="card-title">Data Kampus</h3>
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
                                     <a href="#" class="mr-2" @click="viewKampus(props.row.id)">
                                    <i class="fas fa-eye" style="color : red !important;"></i>
                                </a>
                                  <a href="#" class="mr-2" @click="editModal(props.row)">
                                    <i class="fas fa-user-edit" style="color : lightseagreen !important;"></i>
                                    </a>
                                    <a href="#" @click="deleteKampus(props.row.id)">
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
                        <h5 class="modal-title" v-show="!editmode">Tambah Data Kampus</h5>
                        <h5 class="modal-title" v-show="editmode">Edit Data Kampus</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" style="color : red">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="editmode ? updateKampus() : createKampus()">
                        <div class="modal-body">
                            <div class="form-group">
                                <input v-model="form.nama_kampus" type="text" name="nama_kampus"
                                       class="form-control" :class="{ 'is-invalid': form.errors.has('nama_kampus') }"
                                       placeholder="Nama Kampus">
                                <has-error :form="form" field="nama_kampus"></has-error>
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
                                <textarea v-model="form.alamat_kampus" type="text" name="alamat_kampus"
                                          class="form-control" :class="{ 'is-invalid': form.errors.has('alamat_kampus') }"
                                          placeholder="Alamat Kampus"></textarea>
                                <has-error :form="form" field="alamat_kampus"></has-error>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-6">
                                    <label>Foto Kampus</label>
                                    <img id="diplay_img" v-bind:src="imagePreview" style="border-radius : 5px;max-height : 120px; max-width: 130px;"/><hr/>
                                    <input type="file" name="foto_kampus" class="form-control-file" id="picture" @change="onFileChange">
                                    <has-error :form="form" field="foto_kampus"></has-error>
                                </div>
                                <div class="col-sm-6">
                                    <label>Gambar Peta Kampus</label>
                                    <img id="display_peta" v-bind:src="petaPreview" style="border-radius : 5px;max-height : 97px; max-width: 130px;"/><hr/>
                                    <input type="file" name="peta_kampus" class="form-control-file" id="peta" @change="onFileChange2">
                                    <has-error :form="form" field="peta_kampus"></has-error>
                                </div>
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
                        <h5 class="modal-title">View Data Kampus</h5>
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
                                        <th scope="col">Nama kampus</th>
                                        <th scope="col">Deskripsi</th>
                                        <th scope="col">Tanggal Dibangun</th>
                                        <th scope="col">Alamat kampus</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <th>{{kampus.nama_kampus}}</th>
                                        <td>{{kampus.deskripsi}}</td>
                                        <td>{{kampus.tanggal_dibangun}}</td>
                                        <td>{{kampus.alamat_kampus}}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                Foto Kampus<br>
                                <img class="img-thumbnail" :src="'/images/kampus/'+kampus.foto_kampus" style="width:200px">
                            </div>
                            <div class="col-6">
                                Daftar Gedung<br>
                                <ul id="example-1" v-if="kampus.halls != undefined">
                                    <li v-for="gedung in kampus.halls" :key="gedung.id">
                                        {{ gedung.nama_gedung }}
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                Peta Kampus<br>
                                <img class="img-thumbnail" :src="'/images/kampus/peta/'+kampus.peta_kampus" style="width:400px">
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
                {label: 'Nama Kampus', field: 'nama_kampus'},
                {label: 'Alamat Kampus', field: 'alamat_kampus'},
                {label: 'Tanggal Dibangun', field: 'tanggal_dibangun'},
                {label: 'Action', field: 'action'}
            ],
            rows: [],
            page: 1,
            per_page: 10,
            kampus : {},
            editmode : false,
            form: new Form({
                id : '',
                nama_kampus: '',
                alamat_kampus: '',
                peta_kampus: '',
                deskripsi:'',
                tanggal_dibangun:'',
                foto_kampus: '',
            }),
            imagePreview: '/images/image_placeholder.png',
            petaPreview: '/images/peta_placeholder.png',
        }
    },
    methods:{
        viewKampus(id){
            this.loading = true;
            axios.get('/api/kampus/'+id).then( response => {
                this.kampus = response.data;
            });
            $("#viewData").modal('show');
        },
        getKampus() {
            axios.get('/api/kampus').then(function(response){
                this.rows = response.data.data;
            }.bind(this));
        },
        newModal() {
            this.imagePreview = '/images/image_placeholder.png';
            this.petaPreview = '/images/peta_placeholder.png';
            this.form.reset();
            this.editmode = false;
            $("#addNew").modal('show');
        },
        editModal(kampus) {
            this.form.reset();
            this.editmode = true;
            this.form.fill(kampus);
            this.imagePreview = '/images/kampus/'+kampus.foto_kampus;
            this.petaPreview = '/images/kampus/peta/'+kampus.peta_kampus;
            $("#addNew").modal('show');
        },
        createKampus() {
            const config = {
                headers: { 'content-type': 'multipart/form-data' }
            }
            let formData = new FormData();

            formData.append("nama_kampus", this.form.nama_kampus);
            formData.append("deskripsi", this.form.deskripsi);
            formData.append("alamat_kampus", this.form.alamat_kampus);
            formData.append("tanggal_dibangun", this.form.tanggal_dibangun);
            formData.append("foto_kampus", this.form.foto_kampus);
            formData.append("peta_kampus", this.form.peta_kampus);

            this.$Progress.start();
            axios.post('/api/kampus', formData, config).then( () => {
                Fire.$emit('AfterCreated');
                $("#addNew").modal('hide');
                $('body').removeClass('modal-open');
                $('.modal-backdrop').remove();
                toast.fire({
                    icon: 'success',
                    title: 'Data Kampus sudah ditambahkan!'
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
        deleteKampus(id) {
            swal.fire({
                title: 'Anda yakin?',
                text: "Tindakan ini tidak bisa menghapus data gedung yang mengacu padanya!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Iya, hapus saja!'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.form.delete('/api/kampus/' + id).then(() => {
                        Fire.$emit('AfterCreated');
                        swal.fire(
                            'Deleted!',
                            'Data Kampus sudah dihapus',
                            'success'
                        )
                    });
                }
            });
        },
        updateKampus() {
            this.$Progress.start();
            const config = {
                headers: { 'content-type': 'multipart/form-data' }
            }
            let formData = new FormData();
            formData.append("nama_kampus", this.form.nama_kampus);
            formData.append("deskripsi", this.form.deskripsi);
            formData.append("alamat_kampus", this.form.alamat_kampus);
            formData.append("tanggal_dibangun", this.form.tanggal_dibangun);
            formData.append("foto_kampus", this.form.foto_kampus);
            formData.append("peta_kampus", this.form.peta_kampus);
            formData.append("_method", 'PATCH');
            axios.post('/api/kampus/' + this.form.id, formData, config).then(() => {
                Fire.$emit('AfterCreated');
                $("#addNew").modal('hide');
                swal.fire(
                    'Updated!',
                    'Data Kampus sudah diupdate',
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
            this.form.foto_kampus = event.target.files[0];

            let reader  = new FileReader();

            reader.addEventListener("load", function () {
                this.imagePreview = reader.result;
            }.bind(this), false);

            if( this.form.foto_kampus ){
                if ( /\.(jpe?g|jpg|png|gif)$/i.test( this.form.foto_kampus.name ) ) {

                    console.log("here");
                    reader.readAsDataURL( this.form.foto_kampus );
                }
            }
        },
        onFileChange2(event){
            this.form.peta_kampus = event.target.files[0];

            let reader  = new FileReader();

            reader.addEventListener("load", function () {
                this.petaPreview = reader.result;
            }.bind(this), false);

            if( this.form.peta_kampus ){
                if ( /\.(jpe?g|jpg|png|gif)$/i.test( this.form.peta_kampus.name ) ) {

                    console.log("here");
                    reader.readAsDataURL( this.form.peta_kampus );
                }
            }
        },

    },
    created: function(){
        this.getKampus();
        this.getKampus();
        Fire.$on('AfterCreated', () => {
            this.getKampus();
        })
    }
}
</script>
