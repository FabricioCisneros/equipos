<template>
    <main class="flex-1 relative overflow-y-auto py-6 focus:outline-none" tabindex="0">
        <form @submit.prevent="save">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 px-5">
                <div class="md:items-center md:justify-between flex">
                    <div class="flex-shrink-0">
                      <svg-vue class="h-6 w-6 mr-4 text-gray-700 inline-block" icon="font-awesome.device-regular"></svg-vue>
                    </div>
                    <div class="flex-1 min-w-0 inline-block">
                      <h1 class="py-0.5 text-2xl font-semibold text-gray-900">{{ $t('Asignar equipo') }}</h1>
                    </div>
                  </div>
            </div>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="mt-6 shadow sm:rounded-lg">
                    <loading :status="loading.form" /> 
                    <div class="bg-white md:grid md:grid-cols-3 md:gap-6 px-4 py-5 sm:p-6">

                        <div class="mt-5 md:mt-0 md:col-span-1">
                            
                            <div class="grid grid-cols-3 gap-6">
                                <div class="col-span-3">
                                    <label class="block text-sm font-medium leading-5 text-gray-700" for="role">Estado</label>
                                    <div class="mt-1 relative rounded-md shadow-sm">
                                        <select
                                            v-model="selectedState"
                                            class="mt-1 block form-select w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5"
                                            
                                            @change="updateOficinas"
                                        >
                                        <option value="">Selecciona un estado</option>
                                        <option v-for="state in states" :value="state">{{ state.name }}</option>
                                        </select>
                                    </div>
                                </div>
                                <!-- INPUT DE OFICINA EN LA QUE PERTENECE EL EQUIPO -->
                                <div class="col-span-3">
                                    <label class="block text-sm font-medium leading-5 text-gray-700" for="department">{{
                                        $t('Oficina') }}</label>
                                    <div class="mt-1 relative rounded-md shadow-sm">
                                        <input-select
                                        id="oficina"
                                        v-model="filters.oficinas"
                                        :options="oficinaList"
                                        multiple
                                        option-label="name"
                                        @change="getTickets"
                                    />
                                    </div>
                                </div>
                                <!-- FIN DEL BLOQUE -->
                                <!-- INPUT DE CATEGORIA -->
                                <div class="col-span-3">
                                    <label class="block text-sm font-medium leading-5 text-gray-700" for="categoria">{{
                                        $t('Categoria') }}</label>
                                    <div class="mt-1 relative rounded-md shadow-sm">
                                        <input-select
                                        id="categoria"
                                        v-model="filters.categorias"
                                        :options="categoriaList"
                                        multiple
                                        option-label="name"
                                        @change="getTickets"
                                    >
                                    </input-select>
                                    </div>
                                </div>


                                <!-- INPUT DEL MODELO -->
                                <div class="col-span-3">
                                    <label class="block text-sm font-medium leading-5 text-gray-700" for="modelo">{{
                                        $t('Modelo') }}</label>
                                    <div class="relative rounded-md shadow-sm">
                                        <input
                                        id="modelo"
                                        v-model="filters.modelo"
                                        :placeholder="$t('modelo')"
                                        aria-label="modelo"
                                        class="form-input block w-full rounded-l-md pl-10 text-sm transition ease-in-out duration-150"
                                        @change="getTickets"
                                    >
                                    </div>
                                </div>
                                <!-- FIN DEL BLOQEU -->

                                <!-- INPUT DEL NUMERO DE SERIE -->
                                <div class="col-span-3">
                                    <label class="block text-sm font-medium leading-5 text-gray-700" for="numero_serie">{{
                                        $t('Numero de serie del equipo') }}</label>
                                    <div class="mt-1 relative rounded-md shadow-sm">
                                        <input
                                        id="search"
                                        v-model.lazy="filters.search"
                                        :placeholder="$t('Numero de serie')"
                                        aria-label="Search"
                                        class="form-input block w-full rounded-l-md pl-10 text-sm transition ease-in-out duration-150"
                                        @change="getTickets"
                                    >
                                    </div>
                                </div>
                                
                                <div class="col-span-3">
                                </div>

                            </div>
                        </div>

                        <div class="col-span-2">
                            <div class="col-span-3">
                                <template v-if="equiposList.length >= 0">
                                    <div class="hidden sm:block">
                                        <div class="align-middle inline-block min-w-full border-b border-gray-200">
                                            <table class="table-container min-w-full divide-y divide-gray-200">
                                                <thead>
                                                    <tr>
                                                        <th class="hidden lg:table-cell px-3 py-2 text-left text-xs leading-4 font-medium text-gray-600 uppercase tracking-wider">
                                                            {{ $t('Modelo') }}
                                                        </th>
                                                        <th class="px-3 py-2 text-left text-xs leading-4 font-medium text-gray-600 uppercase tracking-wider whitespace-no-wrap overflow-x-auto">
                                                            {{ $t('Numero de serie') }}
                                                        </th>
                                                        <th class="px-3 py-2 text-left text-xs leading-4 font-medium text-gray-600 uppercase tracking-wider whitespace-no-wrap overflow-x-auto">
                                                            {{ $t('Categoria') }}
                                                        </th>
                                                        <th class="px-3 py-2 text-left text-xs leading-4 font-medium text-gray-600 uppercase tracking-wider whitespace-no-wrap overflow-x-auto">
                                                            {{ $t('Oficina que pertenece') }}
                                                        </th>
                                                        <th class="px-3 py-2 text-left text-xs leading-4 font-medium text-gray-600 uppercase tracking-wider whitespace-no-wrap overflow-x-auto">
                                                            {{ $t('Estado actual') }}
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody class="bg-white divide-y divide-gray-100">
                                                    
                                                    <template v-for="equipos in equiposList">          
                                                    <tr     :class="{ 'selected': equipos.id === selectedRow, 'hovered': equipos.id === hoveredRow }"
                                                            @mouseenter="hoveredRow = equipos.id"
                                                            @mouseleave="hoveredRow = null"
                                                            @click="guardarEquipoId(equipos)">
                                                            <td class="hidden lg:table-cell px-3 py-4 whitespace-no-wrap leading-5">
                                                                <div class="flex items-center">
                                                                    <div class="ml-4">
                                                                        <div class="text-sm leading-5 font-medium text-gray-900">
                                                                            {{ equipos.modelo}}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td class="px-3 py-4 whitespace-no-wrap leading-5">
                                                                    <div class="w-full truncate">
                                                                        {{ equipos.numero_serie }}
                                                                    </div>
                                                            </td>
                                                        <td class="px-3 py-4 whitespace-no-wrap leading-5">
                                                            <div class="w-full truncate">
                                                                {{ equipos.categoria.name }}
                                                            </div>
                                                        </td>
                                                        <td class="px-3 py-4 whitespace-no-wrap leading-5">
                                                            <div class="w-full truncate">
                                                                {{ equipos.oficina.name }}
                                                            </div>
                                                        </td>
                                                        <td class="px-3 py-4 whitespace-no-wrap leading-5">
                                                            <div class="text-sm leading-5 text-gray-900">
                                                                {{equipos.status.name}}
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </template>
                                                
                                                </tbody> 
                                                <tfoot>
                                                    <td colspan="5">
                                                        <nav class="bg-white bottom-0 left-0 w-full px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6">
                                                            <div class="hidden sm:block">
                                                              <p class="text-sm leading-5 text-gray-700">
                                                                {{ $t('Showing') }}
                                                                <span class="font-medium">{{ (pagination.perPage * pagination.currentPage) - pagination.perPage + 1 }}</span>
                                                                {{ $t('to') }}
                                                                <span class="font-medium">{{ pagination.perPage * pagination.currentPage <= pagination.total ? pagination.perPage * pagination.currentPage : pagination.total }}</span>
                                                                {{ $t('of') }}
                                                                <span class="font-medium">{{ pagination.total }}</span>
                                                                {{ $t('results') }}
                                                              </p>
                                                            </div>
                                                            <div class="flex-1 flex justify-between sm:justify-end">
                                                              <button
                                                                :class="pagination.currentPage <= 1 ? 'opacity-50 cursor-not-allowed' : ''"
                                                                :disabled="pagination.currentPage <= 1"
                                                                class="pagination-link"
                                                                type="button"
                                                                @click="changePage(pagination.currentPage - 1)"
                                                              >
                                                                {{ $t('Previous') }}
                                                              </button>
                                                              <button
                                                                :class="pagination.currentPage >= pagination.totalPages ? 'opacity-50 cursor-not-allowed' : ''"
                                                                :disabled="pagination.currentPage >= pagination.totalPages"
                                                                class="ml-3 pagination-link"
                                                                type="button"
                                                                @click="changePage(pagination.currentPage + 1)"
                                                              >
                                                                {{ $t('Next') }}
                                                              </button>
                                                            </div>
                                                          </nav>
                                                    </td>
                                                  </tfoot>
                                            </table>
                                                <label class="block text-sm font-medium leading-5 text-gray-700" for="categoria">{{
                                                    $t('fecha en el que se le entrego el equipo') }}
                                                </label>
                                                 <datepicker :language="es" :format="customFormatter" v-model="selectedDate" :inline=true></datepicker>
                                        </div>
                                    </div>
                               
                                </template>
                            </div>
                        </div>                            
                    </div>
                </div>
            </div>

 
            <!-- SECCION DE EMPLEADOS -->

            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 px-5">
                <div class="md:items-center md:justify-between flex">
                    <div class="flex-shrink-0">
                      <svg-vue class="h-6 w-6 mr-4 text-gray-700 inline-block" icon="font-awesome.user-regular"></svg-vue>
                    </div>
                    <div class="flex-1 min-w-0 inline-block">
                      <h1 class="py-0.5 text-2xl font-semibold text-gray-900">{{ $t('Asignar Usuario') }}</h1>
                    </div>
                  </div>
            </div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="mt-6 shadow sm:rounded-lg">
                    <loading :status="loading.form" /> 
                    <div class="bg-white md:grid md:grid-cols-3 md:gap-6 px-4 py-5 sm:p-6">

                        <div class="mt-5 md:mt-0 md:col-span-1">
                            
                            <div class="grid grid-cols-3 gap-6">
                                <div class="col-span-3">
                                    <label class="block text-sm font-medium leading-5 text-gray-700" for="role">Estado</label>
                                    <div class="mt-1 relative rounded-md shadow-sm">
                                        <select
                                            v-model="selectedStateEmpleado"
                                            class="mt-1 block form-select w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5"
                                            @change="updateOficinasEmpleado"
                                        >
                                        <option value="">Selecciona un estado</option>
                                        <option v-for="state in states" :value="state">{{ state.name }}</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-span-3">
                                    <label class="block text-sm font-medium leading-5 text-gray-700" for="department">{{
                                        $t('Oficina') }}</label>
                                    <div class="mt-1 relative rounded-md shadow-sm">
                                        <input-select
                                        id="oficina"
                                        v-model="filters.oficinasEmpleado"
                                        :options="oficinaListEmpleado"
                                        multiple
                                        option-label="name"
                                        @change="getEmpleados"
                                    />
                                    </div>
                                </div>


                                <!-- INPUT DE OFICINA EN LA QUE PERTENECE EL EQUIPO -->
                                <div class="col-span-3">
                                    <label class="block text-sm font-medium leading-5 text-gray-700" for="turno">{{
                                        $t('Turno') }}</label>
                                    <div class="mt-1 relative rounded-md shadow-sm">
                                        <input-select
                                        id="Turno"
                                        v-model="filters.turnos"
                                        :options="turnoList"
                                        multiple
                                        option-label="name"
                                        @change="getEmpleados"
                                    />
                                    </div>
                                </div>
                                <!-- FIN DEL BLOQUE -->
                                <!-- INPUT DE CATEGORIA -->
                                <div class="col-span-3">
                                    <label class="block text-sm font-medium leading-5 text-gray-700" for="Nombre">{{
                                        $t('Nombre o apellidos del empleado') }}</label>
                                    <div class="mt-1 relative rounded-md shadow-sm">
                                        <input
                                        id="search"
                                        v-model.lazy="filters.nombre"
                                        :placeholder="$t('Nombres/Apellidos')"
                                        aria-label="Search"
                                        class="form-input block w-full rounded-l-md pl-10 text-sm transition ease-in-out duration-150"
                                        @change="getEmpleados"
                                    >
                                    </div>
                                </div>

                                <div class="col-span-3">
                                    <label class="block text-sm font-medium leading-5 text-gray-700" for="email">{{
                                        $t('Correo del empleado') }}</label>
                                    <div class="mt-1 relative rounded-md shadow-sm">
                                        <input
                                        id="search"
                                        v-model.lazy="filters.searchEmpleado"
                                        :placeholder="$t('correo')"
                                        aria-label="Search"
                                        class="form-input block w-full rounded-l-md pl-10 text-sm transition ease-in-out duration-150"
                                        @change="getEmpleados"
                                    >
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-span-2">
                            <div class="col-span-3">
                                <template v-if="equiposList.length >= 0">
                                    <div class="hidden sm:block">
                                        <div class="align-middle inline-block min-w-full border-b border-gray-200">
                                            <table class="table-container min-w-full divide-y divide-gray-200">
                                                <thead>
                                                    <tr>
                                                        <th class="hidden lg:table-cell px-3 py-2 text-left text-xs leading-4 font-medium text-gray-600 uppercase tracking-wider">
                                                            {{ $t('Nombre y apellidos') }}
                                                        </th>
                                                        <th class="px-3 py-2 text-left text-xs leading-4 font-medium text-gray-600 uppercase tracking-wider whitespace-no-wrap overflow-x-auto">
                                                            {{ $t('Correo') }}
                                                        </th>
                                                        <th class="px-3 py-2 text-left text-xs leading-4 font-medium text-gray-600 uppercase tracking-wider whitespace-no-wrap overflow-x-auto">
                                                            {{ $t('Turno') }}
                                                        </th>
                                                        <th class="px-3 py-2 text-left text-xs leading-4 font-medium text-gray-600 uppercase tracking-wider whitespace-no-wrap overflow-x-auto">
                                                            {{ $t('Oficina que pertenece') }}
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody class="bg-white divide-y divide-gray-100">
                                                    
                                                    <template v-for="empleado in empleadoList">
                                                    <tr     :class="{ 'selectedE': empleado.id === selectedRowE, 'hovered': empleado.id === hoveredRowE }"
                                                            @mouseenter="hoveredRow = empleado.id"
                                                            @mouseleave="hoveredRow = null"
                                                            @click="guardarEmpleadoId(empleado)">
                                                            <td class="hidden lg:table-cell px-3 py-4 whitespace-no-wrap leading-5">
                                                                <div class="flex items-center">
                                                                    <div class="ml-4">
                                                                        <div class="text-sm leading-5 font-medium text-gray-900">
                                                                            {{ empleado.name}} {{ empleado.apellidos }}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td class="px-3 py-4 whitespace-no-wrap leading-5">
                                                                    <div class="w-full truncate">
                                                                        {{ empleado.email }}
                                                                    </div>
                                                            </td>
                                                        <td class="px-3 py-4 whitespace-no-wrap leading-5">
                                                            <div class="w-full truncate">
                                                                {{ empleado.turno.name }}
                                                            </div>
                                                        </td>
                                                        <td class="px-3 py-4 whitespace-no-wrap leading-5">
                                                            <div class="w-full truncate">
                                                                {{ empleado.oficina.name }}
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </template>
                                                
                                                </tbody> 
                                                <tfoot>
                                                    <td colspan="5">
                                                        <nav class="bg-white bottom-0 left-0 w-full px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6">
                                                            <div class="hidden sm:block">
                                                              <p class="text-sm leading-5 text-gray-700">
                                                                {{ $t('Showing') }}
                                                                <span class="font-medium">{{ (pagination.perPage * pagination.currentPage) - pagination.perPage + 1 }}</span>
                                                                {{ $t('to') }}
                                                                <span class="font-medium">{{ pagination.perPage * pagination.currentPage <= pagination.total ? pagination.perPage * pagination.currentPage : pagination.total }}</span>
                                                                {{ $t('of') }}
                                                                <span class="font-medium">{{ pagination.total }}</span>
                                                                {{ $t('results') }}
                                                              </p>
                                                            </div>
                                                            <div class="flex-1 flex justify-between sm:justify-end">
                                                              <button
                                                                :class="pagination.currentPage <= 1 ? 'opacity-50 cursor-not-allowed' : ''"
                                                                :disabled="pagination.currentPage <= 1"
                                                                class="pagination-link"
                                                                type="button"
                                                                @click="changePage(pagination.currentPage - 1)"
                                                              >
                                                                {{ $t('Previous') }}
                                                              </button>
                                                              <button
                                                                :class="pagination.currentPage >= pagination.totalPages ? 'opacity-50 cursor-not-allowed' : ''"
                                                                :disabled="pagination.currentPage >= pagination.totalPages"
                                                                class="ml-3 pagination-link"
                                                                type="button"
                                                                @click="changePage(pagination.currentPage + 1)"
                                                              >
                                                                {{ $t('Next') }}
                                                              </button>
                                                            </div>
                                                          </nav>
                                                    </td>
                                                  </tfoot>
                                            </table>
                                        </div>
                                    </div>
                               
                                </template>
                            </div>
                        </div>
                         
                    </div>
                </div>
                
            <div class="bg-gray-100 text-right px-4 py-3 sm:px-6">
                <div class="inline-flex">
                    <router-link class="btn btn-secondary shadow-sm rounded-md mr-4" to="/dashboard/admin/directorios">
                        {{ $t('Cancelar') }}
                    </router-link>
                    <button class="btn btn-green shadow-sm rounded-md btn-long" type="submit">
                        {{ $t('Guardar') }}
                    </button>
                </div>
            </div>
            </div>

        </form>
    </main>
</template>

<script>
import datepicker from 'vuejs-datepicker';
import {en, es} from 'vuejs-datepicker/dist/locale'
import moment from 'moment';

export default {
    name: "new",

    metaInfo() {
        return {
            title: this.$i18n.t('Asignar equipo con empleado')
            
        }
    },
    data() {
        return {
            loading: {
                form: true,
            },
            turnoList:[],
            categoriaList: [],
            oficinaList: [],
            oficinaListEmpleado:[],
            equiposList:[],
            ticket_id:null,
            empleado_id:null,
            animacionOficina:false,
            animacionEmpleado:false,

            hoveredRow: null,
            selectedRow: null,

            hoveredRowE:null,
            selectedRowE:null,


            en: en,
            es: es,
            equipoSeleccionado:null,
            currentOficinaEmpleado:null,
            currentTurnoEmpleado:null,
            currentEstadoEmpleado:null,
            selectedDate:null,
            empleadoList:[],
            selectedState:null,
            selectedStateEmpleado:null,

            //PAGINACION///
            page: 1,
            perPage: 10,
            pagination: {
                currentPage: 0,
                perPage: 0,
                total: 0,
                totalPages: 0
            },
            ////FIN DE LA PAGINACION

            busqueda:{
                modelo:null,
                numero_serie:null,
                oficina_id:null,
                categoria_id:null,
            },

            filters:{
                search: '',
                searchEmpleado:'',
                modelo:'',
                numero_serie: '',
                categorias:[],
                statuses: [],
                oficinas:[],
                turnos:[],
                oficinasEmpleado:[],
                nombre: ''
            },

            directorio:{
             equipo:[],
             empleado:[],
             fecha_asignacion:null
            },
            
            sendDirectorio:{
                empleado_id:null,
                ticket_id:null,
                fecha_asignacion:null
            },
            states: [
        { name: 'Aguascalientes' },
        { name: 'Baja California' },
        { name: 'Baja California Sur' },
        { name: 'Campeche' },
        { name: 'Coahuila' },
        { name: 'Colima' },
        { name: 'Chiapas' },
        { name: 'Chihuahua' },
        { name: 'Ciudad de México' },
        { name: 'Durango' },
        { name: 'Guanajuato' },
        { name: 'Guerrero' },
        { name: 'Hidalgo' },
        { name: 'Jalisco' },
        { name: 'México' },
        { name: 'Michoacán' },
        { name: 'Morelos' },
        { name: 'Nayarit' },
        { name: 'Nuevo León' },
        { name: 'Oaxaca' },
        { name: 'Puebla' },
        { name: 'Querétaro' },
        { name: 'Quintana Roo' },
        { name: 'San Luis Potosí' },
        { name: 'Sinaloa' },
        { name: 'Sonora' },
        { name: 'Tabasco' },
        { name: 'Tamaulipas' },
        { name: 'Tlaxcala' },
        { name: 'Veracruz' },
        { name: 'Yucatán' },
        { name: 'Zacatecas' }
            ]
        }
    },
    components: {
        datepicker
        
    },
    computed: {
        anyFilter() {
            return this.filters.search !== ''
                || this.filters.searchEmpleado
                || this.filters.modelo!==''
                || this.filters.numero_serie.trim() !== ''
                || this.filters.oficinas.length !== 0
                || this.filters.oficinasEmpleado.length!== 0
                || this.filters.categorias.length !== 0
                || this.filters.turnos.length!==0
                || this.filters.nombre!==''
                || this.filters.correo!==''
                
        }
    },
    mounted() {
        this.getDatos();
        this.getDatosEmpleado();

        
    },
    methods: {

        customFormatter(date) {
            return moment(date).format('D MM YYYY'); // Ajusta el formato según tus necesidades
        },
        changePage(page) {
            const self = this;
            if ((page > 0) && (page <= self.pagination.totalPages) && (page !== self.page)) {
                self.page = page;
                self.getTickets();
            }
        },
        getDatos(){
            const self=this;
            self.loading.form=true;
            axios.get('api/dashboard/admin/directorio/datosEquipo').then(function(response){
                self.oficinaList = response.data.oficinas;
                self.categoriaList=response.data.categorias;
                 self.loading.form = false;
            }).catch(function(){
                self.loading.form = false;
            });
        },
        
        getDatosEmpleado(){
            const self = this;
            self.loading.form=true;
            axios.get('api/dashboard/admin/directorio/datosEmpleado').then(function(response){
                self.turnoList=response.data.turnos;
                self.oficinaListEmpleado=response.data.oficinas;
                //console.log(self.turnoList);
            }).catch(function(){
                self.loading.form=false;
            });
        },
        guardarEquipoId(equipo){
            const self=this;
            this.selectedRow = equipo.id;
            this.directorio.equipo=equipo;
            self.animacionOficina=true;
           
        },

        guardarEmpleadoId(empleado){
            const self=this;
            self.selectedRowE=empleado.id;
            self.directorio.empleado=empleado;
            self.currentOficinaEmpleado=empleado.oficina.name;
            self.currentEstadoEmpleado=empleado.oficina.estado;
            self.currentTurnoEmpleado=empleado.turno.name;
            
        },
        updateOficinas(){

            const self=this;
           // console.log(self.selectedState);
            //console.log(self.selectedState.name);
            axios.get('api/dashboard/admin/directorio/updateOficinasList/'+self.selectedState.name).then(function(response){  
                self.oficinaList =response.data.oficinas;
            }).catch(function(){
                self.loading.form;
            });
        },
        updateOficinasEmpleado(){
            const self=this;
           // console.log(self.selectedState);
           // console.log(self.selectedStateEmpleado.name);
            axios.get('api/dashboard/admin/directorio/updateOficinasList/'+self.selectedStateEmpleado.name).then(function(response){  
                self.oficinaListEmpleado =response.data.oficinas;
            }).catch(function(){
                self.loading.form;
            });
        },

        getTickets() {
            const self = this;
            self.loading.form = true;
            
            const params = {
                page: self.page,
                sort: self.sort,
                perPage: self.perPage,
                search: self.filters.search,
                statuses: self.filters.statuses,
                categorias: self.filters.categorias,
                oficinas: self.filters.oficinas,
                // Agrega las propiedades del filtro de modelo y número de serie
                modelo: self.filters.modelo,
                numero_serie: self.filters.numero_serie
            };

            axios.get('api/dashboard/admin/directorio/getTickets', {
                params: params
            }).then(function (response) {
               // console.log(response.data.items);
                self.equiposList=response.data.items;
                self.pagination = response.data.pagination;
                
                if (self.pagination.totalPages < self.pagination.currentPage) {
                    self.page = self.pagination.totalPages;
                    self.getTickets();
                } else {
                    self.loading.form = false;
                }
            }).catch(function () {
                self.loading.form = false;
                
            });
        },

        getEmpleados(){
            const self=this;
            self.loading.form =true;

            const params ={
                page: self.page,
                sort:self.sort,
                perPage:self.perPage,
                ///Datos //
                search: self.filters.searchEmpleado,
                nombre: self.filters.nombre,
                apellidos:self.apellidos,
                turno:self.filters.turnos,
                oficinas:self.filters.oficinasEmpleado,
                correo:self.correo
            };

            axios.get('api/dashboard/admin/directorio/getEmpleados',{
                params:params
            }).then(function(response){
                self.empleadoList=response.data.items;
                self.pagination=response.data.pagination;
                // console.log(self.empleadoList);        
                if (self.pagination.totalPages < self.pagination.currentPage) {
                    self.page = self.pagination.totalPages;
                    self.getTickets();
                } else {
                    self.loading.form = false;
                }
            }).catch(function(){
                self.loading.form=false;
            });
        },

        save(){
            const self = this;
            self.sendDirectorio.fecha_asignacion=moment(self.selectedDate).format('YYYY-MM-D');
            self.sendDirectorio.ticket_id=self.directorio.equipo.id;
            self.sendDirectorio.empleado_id=self.directorio.empleado.id;
            console.log(self.sendDirectorio);
            self.loading.form=true;

            axios.post('api/dashboard/admin/directorio',self.sendDirectorio).then(function(response){
                self.loading = false;
                self.$notify({
                    title:self.$i18n.t('completado').toString(),
                    text:self.$i18n.t('relacion creada').toString(),
                    type:'success'
                });
                self.$router.push('/dashboard/Directorio-de-equipos');
            }).catch(function(){
                self.loading.form=false
            });

        }


    },
}
</script>

<style>
.grid-cols-3 {
    flex: 1;
  }
  
  .grid-cols-4 {
    flex: 1;
  }
  
  .shadow-sm {
    box-shadow: none;
  }
  .table-container {
    height: 400px; /* altura fija de la tabla */
    overflow-y: auto; /* habilite el desplazamiento vertical */
  }

  .selected-equipment {
    padding: 20px;
    border: 1px solid #ccc;
    border-radius: 5px;
    background-color: #f8f8f8;
    margin-bottom: 20px;
  }
  
  .selected-equipment__title {
    font-size: 18px;
    margin-bottom: 10px;
  }
  
  .selected-equipment__content {
    font-size: 16px;
    line-height: 1.5;
  }
  .fade-enter-active, .fade-leave-active {
    transition: opacity .5s;
  }
  .fade-enter, .fade-leave-to {
    opacity: 0;
  }
  /* Modificar el estilo del input */
 .vdp-datepicker{
    background-color: #fff;
    border: 1px solid #ccc;
    border-radius: 3px;
    color: #333;
    font-size: 14px;
    padding: 5px;
 }
 .vdp-datepicker__input{
    background-color: #fff;
    border: 1px solid #ccc;
    border-radius: 3px;
    color: #333;
    font-size: 14px;
    padding: 5px;
 }
 .vdp-datepicker__input[text] {
    background-color: #fff;
    border: 1px solid #ccc;
    border-radius: 3px;
    color: #333;
    font-size: 14px;
    width: 100%;
  }

  .table-container tbody tr:hover {
    background-color: rgb(237, 243, 245);
  }
  
  .table-container tbody tr.selected {
    background-color: rgb(61, 218, 218);
    box-shadow: 0 0 5px rgba(0, 0, 0, 0.3), inset 0 0 5px rgba(0, 0, 0, 0.3);
  }

  
  .table-container tbody tr.selectedE {
    background-color: rgb(61, 218, 218);
    box-shadow: 0 0 5px rgba(0, 0, 0, 0.3), inset 0 0 5px rgba(0, 0, 0, 0.3);
  }
  .btn-long {
    width: 200px; /* Ajusta el valor según el ancho deseado */
}

</style>