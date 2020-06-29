
<!--the xmlns:v-slot was exported automatically when trying to use v-slot to add buttons to rows -->
<template xmlns:v-slot="http://www.w3.org/1999/XSL/Transform">

    <div>
        <!--If the loading data property is set to true, display the spinner, else hide it-->
        <div v-if="loading" class="text-center">
            <b-spinner variant="primary" label="Spinning" size="lg"></b-spinner>
        </div>
        <!--https://bootstrap-vue.js.org/docs/components/table/ -->
        <!-- This link provides helpful information on setting up a table in vue -->
        <!-- use in the script tag along side axios to grab data from api with the :items
        the :no-provider-sorting option allows the columns to be sorted-->
        <b-table class="table table-dark table-striped"
            id="vehicleTable"
            :items="listVehicles"
            :fields="fields"
            :no-provider-sorting="true"
        >

            <!-- For each row in the table it will add a column with an edit button for each vehicle
            Which will then emit an edit event handler passing in the clicked vehicle-->
            <!-- the v-slot:cell tells vue that for each row in the edit column - add a edit button-->
            <template v-slot:cell(edit)="row">
                <b-button  class="btn btn-primary far fa-edit" @click.stop="$emit('edit', row.item)">Edit Vehicle</b-button>
           </template>
        </b-table>

    </div>

</template>

<script>

    module.exports = {

        //A list of data used to store attributes
        data: function()
        {

            return{
                //This loading boolean, will determine when to display the spinner
                loading: Boolean,
                //a list of fields used as table column names for the table
                //The sortable attributes allows them to be sorted
                fields: [
                    {key: 'vehicleID', sortable: true},
                    {key: 'make', sortable: true},
                    {key: 'model', sortable: true},
                    {key:'type', sortable: true},
                    {key: 'year', sortable: true},
                    {key: 'edit', Label: 'Edit Vehicle'}
                ],
            }
        },
        //A list of method(s)
        methods: {
            //Uses a promised based provider combined with axios to get a list of vehicles and
            //populates the table
            //https://bootstrap-vue.js.org/docs/components/table/ --Under the 'Using items provider functions'
            listVehicles: function () {
                //sets the loading to true - displays the spinner
                this.loading = true;
                //Uses axios to grab vehicle data and puts it in a promise based provider
                const promise = axios.get("vehicle-api.php", {params: {}});

                //returns the promise with a list of all vehicle records
                return promise.then(response => {
                    const items = response.data;
                    //sets the loading to false - hides the spinner
                    this.loading = false;
                    //returns all the vehicle records which is put inside
                    return(items);

                    //If the table holds no data then return an empty array and set the spinner to false
                    //In doing so the web page will not be stuck in an infinite loop.
                    //https://bootstrap-vue.js.org/docs/components/table/ --Under the 'Automated table busy state'
                }).catch(error => {
                    this.loading = false;
                    return [];
                });

            }

        },
        //This will call the listVehicles function to populate data
        mounted() {
            this.listVehicles();
        }
    }

</script>

<style type="text/css" scoped>
</style>