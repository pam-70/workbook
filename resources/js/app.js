/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('studentyear-component', require('./components/StudentyearComponent.vue').default);//работа студента отвечать на вопросы
Vue.component('listtasks-component', require('./components/ListtasksComponent.vue').default);//редактирование listtasks

Vue.component('header-component', require('./components/student/HeaderComponent.vue').default);//кто выполняет и выход из формы
Vue.component('start-component', require('./components/student/StartComponent.vue').default);//форма для начала выполнения теста
Vue.component('show-component', require('./components/student/ShowComponent.vue').default);//показ данных при выполнении
Vue.component('quest-component', require('./components/student/QuestComponent.vue').default);//вывод вопроса
Vue.component('radio-component', require('./components/student/RadioComponent.vue').default);//радио боксы ответы
Vue.component('check-component', require('./components/student/CheckComponent.vue').default);//чекбоксы
Vue.component('written-component', require('./components/student/WrittenComponent.vue').default);//письменный ответ
Vue.component('toanswer-component', require('./components/student/ToanswerComponent.vue').default);//кнопка начать  выполнения задания
Vue.component('viewing-component', require('./components/student/ViewingComponent.vue').default);//просмотр последненго задания
Vue.component('result-component', require('./components/student/ResultComponent.vue').default);//просмотр всех выполненных заданий
Vue.component('testexecution-component', require('./components/student/TestexecutionComponent.vue').default);//главное окно

Vue.component('viewingratings-component', require('./components/admin/ViewingratingsComponent.vue').default);//главное окно
Vue.component('schoolklass-component', require('./components/admin/SchoolklassComponent.vue').default);//школы класс
Vue.component('viewingtasks-component', require('./components/admin/ViewingtasksComponent.vue').default);//просмотр тестов заданий
Vue.component('installbaza-component', require('./components/admin/InstallbazaComponent.vue').default);//установки работы
Vue.component('addstudent-component', require('./components/admin/AddstudentComponent.vue').default);//Добавить студентов

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});
