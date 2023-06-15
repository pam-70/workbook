<template>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Страница добавления учащихся</div>
                    <div class="card-header">
                        <div class="container">
                            <div class="row">
                                <div class="col-sm-auto">
                                    <select id="selectschool" v-model="selected" @mouseup="filtrklass()">
                                        <option :value="school.id" v-for="school in all_school" :key="school.id">
                                            {{ school.nameschool }}
                                        </option>
                                    </select>
                                    <select v-model="selected_klass" @mouseup="filtrpassw()">
                                        <option :value="klass.id" v-for="klass in all_klass" :key="klass.id">
                                            {{ klass.nameklass }}
                                        </option>
                                    </select>
                                </div>
                                <div class="col-sm-2">
                                    <input class="form-control form-control-sm" type="password" v-model="password"
                                        placeholder="Пароль" />
                                </div>
                                <div class="col-sm-2">
                                    <input class="form-control form-control-sm" type="text" v-model="kolstudent"
                                        placeholder="Кол. учеников" />
                                </div>
                                <div class="col">
                                    <button type="button" class="btn btn-primary" @click="addstudent">
                                        Добавить
                                    </button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-2">

                                </div>

                                <div class="col"> </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-11">
                            <div class="butv" v-for="result in user_data" :key="result.message">
                                <span>
                                    {{
                                     " Ученик логин № " +
                                        result.numer+" логин "+ result.name+" пароль "+result.password_srtr
                                    }}
                                </span>
                            </div>
                        </div>
                        <div class="col-md-1">
                            <button type="button" class="btn btn-danger" data-bs-toggle="tooltip" data-bs-placement="top"
                                title="Очистить результаты" @click="clearform()">
                                X
                            </button>
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
            all_school: [],
            all_klass: [],
            selected: "",
            selected_klass: "",
            kolstudent: "",
            password: "",
            password_str: "",
            user_data: "",
            allresult: "",
            checkedtest: false,
            quarter: "", //четверть
        };
    },
    mounted() {
        this.update();
    },
    methods: {
        update: function () {
            //получить данные об usere
            //console.log("0000000000000000");
            // this.formatdate();
            axios.post("/updateadmin").then((response) => {
                this.all_school = response.data.school;
                this.password_str = response.data.password;

                //console.log(response.data);
            });
        },
        filtrpassw: function (klass_id) {

            const data_url = {
                // передаем данные
                klassid: this.selected_klass,
            };
            console.log(this.selected_klass);
            if (this.selected > 0 && this.selected_klass > 0 ) {
                axios.post("/filtrpass", data_url).then((response) => {
                    this.user_data = response.data.result;
                });
            }

        },
        filtrklass: function () {
            //фильтруем классы
            const data_updat = {
                // передаем данные
                schoolid: this.selected,
            };
            // console.log(this.selected);
            if (this.selected > 0) {
                axios.post("/filtrklass", data_updat).then((response) => {
                    this.all_klass = response.data.klass;
                });
            }
        },

        clearform: function () {
            this.allresult = "";

        },
        addstudent: function () {
            if (this.password === this.password_str && this.kolstudent > 0 && this.selected_klass > 0 && this.selected > 0) {
                const data_addst = {
                    // передаем данные
                    schoolid: this.selected,
                    klassid: this.selected_klass,
                    kolstudent: this.kolstudent,
                };
               // console.log("oooooooooooooooo");
                axios.post("/addstudent", data_addst).then((response) => {
                    //this.all_klass = response.data.klass;
                    console.log(response.data.result);
                });
            }
            this.password = "";
        }
    },
};
</script>
