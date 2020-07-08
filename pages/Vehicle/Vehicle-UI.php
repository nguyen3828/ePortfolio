<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- https://bootswatch.com themes: cerulean cosmo cyborg darkly flatly journal litera lumen lux
	materia	minty pulse sandstone simplex sketchy slate solar spacelab superhero united yeti -->
    <!-- These scripts and links allow us to use vue, axios, and bootstrap to it's full potential -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootswatch/4.3.1/yeti/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-vue/dist/bootstrap-vue.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.11.2/css/all.css">
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/portal-vue/dist/portal-vue.umd.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-vue/dist/bootstrap-vue.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/http-vue-loader/src/httpVueLoader.js"></script>



    <title>VehicleUI by cst210, cst213, cst223</title>
</head>
<body>
<div class="jumbotron text-center">
    <h1>Vehicle Table</h1>
    <br>
    <h2>VehicleUI by cst210, cst213, cst223 </h2>
</div>
<!--A container that contains single vue file components which contains a vehicle table and a input modal -->
<div class="container" id="managed_by_vue_js">

    <!-- This single file component is responsible for setting up the input modal-->
    <vehicle-input :vehicle="vehicle" @save="saveVehicle" :loading-mode="loading" ></vehicle-input>

    <!-- This button will open up the modal with empty input fields-->
    <button  @click="openModal" class="btn btn-default btn-sm">
        <span class="fas fa-plus fa-2x"> </span>
    </button>

    <!-- This single file component is responsible for display a table alongside edit buttons-->
   <vehicle-table @edit="copyVehicle" :vehicle="vehicle" :vehicles="vehicles" ></vehicle-table>



</div>
<!-- Vue will manage state management of data -->
<script>
    new Vue({
        el: '#managed_by_vue_js',
        //data holds a list of vehicles, a loading boolean, and an empty vehicle used for edit purposes
        data: {
            vehicles:[],
            axiosResult: {},
            //sets loading to false, disable spinner
            loading: false,
            //makes an empty vehicle used for editing purposes
            vehicle:{vehicleID:null, make:'',model:'',type:'',year:null},

        },
        methods: {

            //This function will attempt to save the vehicle to the database
            //Vehicle - the vehicle to save
            //error messages - a list of error messages if it fails validation
            //status -- the status of the vehicle (Created, Updated, error, etc.)
            saveVehicle: function(vehicle,errorMessages,status) {

                this.loading = true;
                axios({
                    method: vehicle.vehicleID ? 'put':'post',/*determine which method by whether the vehicleID is set*/
                    url: 'vehicle-api.php',
                    data: vehicle
                })
                    .then(response=> {
                        this.axiosResult = response;//ONLY FOR DEBUG
                        status.code = 1; //let the computer know that the vehicle was successfully added to the db
                        if(response.status == 201){//CREATED and added to database

                            //this will hide the single file modal component
                            this.$bvModal.hide('bmodal-vehicle');
                            //refreshes the table based on the ID of that table
                            //Found in https://bootstrap-vue.js.org/docs/components/table/ -- Force refreshing of table data
                            this.$root.$emit('bv::refresh::table', 'vehicleTable');

                        }
                        if(response.status == 200) {//student updates in database
                            //same as the other status as above, hide the modal and refresh vehicle data
                            this.$bvModal.hide('bmodal-vehicle');
                            this.$root.$emit('bv::refresh::table', 'vehicleTable');
                        }
                    })
                    .catch(errors=>{
                        let response = errors.response;
                        this.axiosResult = response;//ONLY FOR DEBUG
                        status.code = 0;// let the component know that it did not save to db
                        if(response.status == 422){//validation error
                            Object.assign(errorMessages,response.data) // copy the errormessages to the error object inside the component
                        }else if(response.status == 418){//database error -expect debug sql text to be returned
                            this.sqlDebug = response.data;
                        }
                    })
                    .finally(()=>{this.loading=false;})// disable loading
            },
            //This function will copy the vehicle data from the table and places it into the form inputs
            copyVehicle:function(vehicle){
                //sets the vehicle to the (edit)vehicle passed in
                this.vehicle = vehicle;
                this.$bvModal.show('bmodal-vehicle');


            },
            //This function will open the modal with empty input fields
            openModal:function(){
                this.vehicle = {};
                this.$bvModal.show('bmodal-vehicle');
    }

        },
        //This will load both the table and the input modal
        components: {
            'vehicle-table': httpVueLoader('./VehicleTable.vue'),

            'vehicle-input': httpVueLoader('./VehicleInput.vue') //'.' in the file path indicates the current level
        },

    });
</script>

</body>
</html>