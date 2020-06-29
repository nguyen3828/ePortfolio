<template>
    <!-- b-moal that will pops up when user press Add or edit button through  ui-->
    <b-modal :title="title" v-model="modalShown" @change="copyVehicle" hide-footer id="bmodal-vehicle" :no-close-on-backdrop="loadingMode" :no-close-on-esc="loadingMode" :hide-header-close="loadingMode">

            <!--//https://bootstrap-vue.js.org/docs/components/form-radio/-->
            <!--https://bootstrap-vue.js.org/docs/components/form-input/-->
            <!--https://bootstrap-vue.js.org/docs/components/modal/-->
            <!--label for make -->
            <label>Make:</label>
            <!--input for Make that includes make related  errors, state, also it is connected to the newVehicle.make
             it checks the status of loading if it is loading then the input box will become disabled -->
            <b-form-group :invalid-feedback="errors.make" :state="states.make" >
                <b-form-input v-model="newVehicle.make"  :state="states.make" @input = "errors.make=null" :disabled="loadingMode" trim></b-form-input>
            </b-form-group>
            <!--input for Model that includes model related  errors, state, also it is connected to the newVehicle.model
            it checks the status of loading if it is loading then the input box will become disabled -->
            <label>Model:</label>
            <b-form-group :invalid-feedback="errors.model" :state="states.model">
                <b-form-input v-model="newVehicle.model" :state="states.model"  @input = "errors.model=null" :disabled="loadingMode" trim></b-form-input>
            </b-form-group>
            <!--spinner tha checks the status of loadingMode when it is true start showing until loading mode become false
            this handledh through loading-mode kebab in ui -->
            <div v-if = "loadingMode" class="text-center">
                <b-spinner variant="primary" label="Spining" size="lg"></b-spinner>
            </div>
           <!--radio buttons that shows the type of car. It will becomes disable during loading -->
            <!-- it also checks the error state for radio buttons -->
            <b-form-group label="Type:" :invalid-feedback="errors.type" :state="states.type" :disabled="loadingMode">
                <b-form-radio  v-model="newVehicle.type"  value="Sedan" :state="states.type" @input="errors.type=null">Sedan</b-form-radio>
                <b-form-radio  v-model="newVehicle.type"   value="Compact" :state="states.type" @input="errors.type=null">Compact</b-form-radio>
                <b-form-radio  v-model="newVehicle.type" value="Cross Over" :state="states.type" @input="errors.type=null">Cross Over</b-form-radio>
                <b-form-radio  v-model="newVehicle.type"  value="Truck" :state="states.type" @input="errors.type=null">Truck</b-form-radio>
            </b-form-group>
            <!--the input that deal with the year of the car -->
            <label>Year:</label>
             <!--input for Year that includes year related  errors, state, also it is connected to the newVehicle.year
              it checks the status of loading if it is loading then the input box will become disabled -->
            <b-form-group :invalid-feedback="errors.year" :state="states.year">
                <b-form-input v-model="newVehicle.year" :state="states.year" :disabled="loadingMode"></b-form-input>
            </b-form-group>
            <!--button that save the new car to the database through ui and api-->
            <button class="btn btn-primary far fa-save" title="Save" @click.stop="saveVehicle" > Save</button>

    </b-modal>

</template>
<script>
    module.exports ={
        props:{ //this part inherent vehicle from his ui parent
            vehicle:{
                type: Object, //its type
                default:()=>({vehicleID:null,make:'', model:'',type:'',year:null}) //default value for vehicle
            },
            loadingMode:{//check for loading page
                type:Boolean, //its type
                default:()=>(false) // the default value
            }
        },
        data:function(){ //copied data from passing vehicle to the newVehicle temporarily
            return{
                newVehicle: Object.assign({},this.vehicle),
                errors:{},
                status:{code:0}, //Status code 0 - nothing to update
                modalShown: false,//default for bmodal show

            }
        },
        methods:{
            //This method will save the vehicle to the database
            saveVehicle: function(){
                this.errors = {vehicleID:null, make:'',model:'',type:'',year:''};
                this.status.code = -1; // means we wait for the server response
                //newVehicle is connected to the text inputs - so we need to send that object to ui to save new values to the database
                this.$emit('save',this.newVehicle,this.errors,this.status);

            },
            //copy passed vehicle to the new vehicle inside the b-modal
            copyVehicle: function(){
                this.newVehicle = Object.assign({},this.vehicle);
                this.errors = {};
            }



        },

        computed:{ //computed that check the error for each vehicle field
            states: function(){
                return{
                    make: this.errors.make ? false : null,
                    model: this.errors.model ? false: null,
                    year: this.errors.year ? false : null,
                    type: this.errors.type ? false : null
                }
            },

            //check if the vehicle has id then it is a edit vehicle else it is a new vehicle
            title: function(){
                return  this.vehicle.vehicleID ? 'Edit Vehicle':'New vehicle';
            }

        },



    }
</script>




