<template>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Параметры установки работы</div>
                    <div class="card-header">
                        <div class="container">

                            <div class="row" v-if="showform">
                                <div class="col-sm-auto"></div>
                                <div class="col-sm-3">
                                    <input class="form-control form-control-sm" type="text" v-model="name"
                                        placeholder="название" />
                                </div>
                                <div class="col-sm-2">
                                    <input class="form-control form-control-sm" type="text" v-model="konst"
                                        placeholder="константа" />
                                </div>
                                <div class="col-sm-2">
                                    <input class="form-control form-control-sm" type="text" v-model="dt_n"
                                        placeholder="начало" />
                                </div>
                                <div class="col-sm-2">
                                    <input class="form-control form-control-sm" type="text" v-model="dt_k"
                                        placeholder="окончание" />
                                </div>
                                <div class="col-sm">

                                    <button type="button" class="btn btn-primary">
                                        <img src="/ikon/save.png" @click="save()">

                                    </button>
                                    <button type="button" class="btn btn-danger" @click="exit()">X</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-11">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">id</th>
                                        <th scope="col">Название</th>
                                        <th scope="col">Константа</th>
                                        <th scope="col">Начало</th>
                                        <th scope="col">Окончание</th>
                                        <th scope="col">Изменить</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="instal_v in instal" :key="instal.id">
                                        <th scope="row">{{ instal_v.id }}</th>
                                        <td>{{ instal_v.name_instal }}</td>
                                        <td>{{ instal_v.data }}</td>
                                        <td>{{ instal_v.data_n }}</td>
                                        <td>{{ instal_v.data_k }}</td>
                                        <td>
                                            <button type="button" class="btn btn-primary">
                                                <img src="/ikon/penm.png"
                                                    @click="edit(instal_v.id, instal_v.name_instal, instal_v.data, instal_v.data_n, instal_v.data_k)">

                                            </button></td>
                                    </tr>


                                </tbody>
                            </table>


                        </div>
                        <div class="col-md-1">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data: function () {
        return {
            instal: "",
            numertest: "",
            showform: false,
            id: "",
            name: "",
            konst: "",
            dt_n: "",
            dt_k: "",


        };
    },
    mounted() {
        this.update();
    },
    methods: {
        update: function () {

            axios.post("/updateinstall").then((response) => {
                this.instal = response.data.instal;
                //console.log(response.data.instal);
            });
        },

        edit: function (id, name, konst, d_n, d_k) {
            this.showform = true;
            // вывод результатов
            this.id = id;
            this.name = name;
            this.konst = konst;
            this.dt_n = d_n;
            this.dt_k = d_k;

            //console.log(this.dt_k);


        },
        save: function () {
            this.showform = false;
            const data_in = {
                id: this.id,
                name: this.name,
                konst: this.konst,
                d_n: this.dt_n,
                d_k: this.dt_k,
            };
            axios.post("/saveinstal", data_in).then((response) => {
            });
            this.update();  
        },
        exit: function () {
            this.showform = false;
            // вывод результатов
            this.id = "";
            this.name = "";
            this.konst = "";
            this.dt_n = "";
            this.dt_k = "";

        },
    },
};
</script>
