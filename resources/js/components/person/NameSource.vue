<template>
    <div id="name-sources">
            <div v-for="(row, index) in rows" :key=row.id class="card mb-3">

                <input type="hidden" v-model="row.id" />

                <div class="card-body">

                    <div class="form-group form-row">
                        <label class="col-md-2 col-form-label text-md-right">Источник</label>
                        <div class="col-md-5">
                            <select v-model="row.type_id" class="form-control">
                                <option v-for="(item, ind) in sourceTypes" v-bind:value="item.id" v-bind:selected="ind === 0">{{ item.name }}</option>
                            </select>
                        </div>
                        <div class="col-md-5">
                            <input type="button" class="btn btn-danger float-right" @click="removeRow(index)" value="X">
                        </div>
                    </div>

                    <div class="form-group form-row">
                        <label class="col-md-2 col-form-label text-md-right">Сведения</label>
                        <div class="col-md-10">
                            <textarea v-model="row.description" class="form-control" rows="3"></textarea>
                        </div>
                    </div>

                    <div class="form-group form-row">
                        <label class="col-md-2 col-form-label text-md-right">Место хранения первоисточника</label>
                        <div class="col-md-10">
                            <textarea class="form-control" type="text" v-model="row.place" rows="3"></textarea>
                        </div>
                    </div>

                    <div class="form-group form-row">
                        <label class="col-md-2  col-form-label text-right">Экспертиза</label>
                        <div class="form-check form-check-inline">
                            <input type="checkbox" v-model="row.expertise">
                        </div>
                    </div>

                    <div v-if="row.expertise">

                        <div class="form-group form-row">
                            <label class="col-md-2 col-form-label text-md-right">Дата</label>
                            <div class="col-auto">
                                <input class="form-control" type="date" v-model="row.expertise_date" />
                            </div>
                        </div>

                        <div class="form-group form-row">
                            <label class="col-md-2 col-form-label text-md-right">Учреждение</label>
                            <div class="col-md-10">
                                <input class="form-control" type="text" v-model="row.expertise_object" />
                            </div>
                        </div>

                        <div class="form-group form-row">
                            <label class="col-md-2 col-form-label text-md-right">Эксперт</label>
                            <div class="col-md-10">
                                <input class="form-control" type="text" v-model="row.expertise_person" />
                            </div>
                        </div>

                    </div>


                    <div v-for="(file, fileindex) in row.files" :key="file.id" class="form-group form-row">
                        <label class="col-md-2 col-form-label text-md-right">#{{fileindex+1}}</label>
                        <div v-if="file.filename" class="col-md-6">
                            <a :href="`/base/public/files/uploads/${file.filename}`" target="_blank">
                                <template v-if="file.ext == 'pdf'">
                                    [pdf]
                                </template>
                                <template v-else>
                                    <img :src="`/base/public/files/uploads/${file.filename}`" height="50px" />
                                </template>
                            </a>
                        </div>
                        <div v-else class="col-md-6">
                            <input type="file" class="form-control" v-on:change="uploadFile($event, index)" />
                        </div>
                        <div class="col-auto">
                            <input type="button" class="btn btn-danger" @click="removeFile(index, fileindex, file.id)" value="X">
                        </div>
                    </div>

                    <input type="button" class="btn btn-primary " @click="addFile(index)" value="Добавить Файл" />

                </div>

            </div>

            <input type="button" class="btn btn-primary" @click="addRow" value="Добавить">

    </div>
</template>

<script>
    export default {
        name: "nameSource",
        props: {
            'rowsData': {
                type: Array,
                default: () => ([])
            },
            'sourceTypes': {
                type: Array
            }
        },
        data: function() {
            return {
                selected: 1,
                rows: [],
                uploads: {},
                deletes: []
            }
        },
        methods: {
            addRow: function() {
                this.rows.push({});
            },
            addFile: function(index) {
                if (!this.rows[index].files)
                    Vue.set(this.rows[index], 'files', []);
                this.rows[index].files.push({});
            },
            uploadFile: function(e, index, fileindex) {
                let selectedFile = e.target.files[0];
                if (!selectedFile)
                    return false;

                if (selectedFile.size > 10* 1024 * 1024) {
                    e.preventDefault();
                    alert('Файл больше 10МБ');
                    return false;
                }

                if (selectedFile.type !=='image/jpeg' && selectedFile.type !== 'image/png' && selectedFile.type !== 'application/pdf') {
                    e.preventDefault();
                    alert('Разрешены файлы с расширением jpeg, png или pdf');
                    return false;
                }

                if (!this.uploads[index])
                    Vue.set(this.uploads, index, []);

                e.target.disabled = true;

                this.uploads[index].push(selectedFile);
            },
            removeFile: function(index, fileindex, fileId) {
                if (typeof fileId != 'undefined') {
                    this.deletes.push(fileId)
                }

                Vue.delete(this.rows[index].files, fileindex);

                if (this.uploads[index])
                    Vue.delete(this.uploads[index], fileindex);
            },
            removeRow: function(index) {
                Vue.delete(this.rows, index);
                if (this.uploads)
                    Vue.delete(this.uploads, index);
            }
        },
        mounted() {
            this.rows = this.rowsData;
        }
    }
</script>

<style>

</style>
