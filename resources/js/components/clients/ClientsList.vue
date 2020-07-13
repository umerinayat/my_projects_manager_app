<template>
   <div>
        <ul class="clients-list">
            <li  v-for="client in clients" :key="'c-'+client.id" ref="listItems" :id="client.id"  @click="showClientDetails(client)">
                {{client.name}}
            </li>
        </ul>
   </div>
</template>

<script>



export default {
    components: {
        
    },
    created() {
        this.getCurrentRouteName();
        this.getClients();
        Fire.$on('onClientCreated', () => {
            this.getClients();
        });
         Fire.$on('onClientUpdated', () => {
             this.getClients();
        });
        Fire.$on('onClientDeleted', () => {
             this.getClients();
        });
          Fire.$on('onFilterClientsByProduct', (product) => {
            if(product) {
                this.FilterClientsByProduct(product);
            } else {
                this.getClients();
            }
        });

        Fire.$on('onUpdateClientListState', (id) => {
            this.updateClientListState(id);
        });
    },
    data() {
        return {
            baseUrl: '/api/',
            clients: [],
            prevSelected: null,
            currentRouteName: "",
         
        };
    },
    methods: {
        getClients() {
            this.$Progress.start();
            axios.get(this.baseUrl + 'client')
            .then(({data})=>{
                if(data.success) {
                    this.$Progress.finish();
                    this.clients = data.clients;
                }
            });
        },
        FilterClientsByProduct(product) {
            this.$Progress.start();
            axios.get(this.baseUrl + 'client/FilterClientsByProduct/' + product.id)
            .then(({data})=>{
                if(data.success) {
                    this.$Progress.finish();
                    this.clients = data.clients;
                }
            });
        },
        showClientDetails(client) {
            
            if(this.currentRouteName == "projects" || this.currentRouteName == "projectDetails") {

                this.$router.push({ name: 'projectDetails', params: { id: client.id } });     

                return;
            }

            if(this.currentRouteName == "timetracking" || this.currentRouteName == "timetrackingDetails") {

                this.$router.push({ name: 'timetrackingDetails', params: { id: client.id } });     

                return;
            }
            
            console.log(this.$refs.listItems);

            if(this.prevSelected != null) {
              this.prevSelected.css('backgroundColor', '#7A8088');
            }
            this.prevSelected = $(event.target);
            $(event.target).css('backgroundColor', '#3E4652');
         
            this.$router.push({ name: 'clientDetails', params: { id: client.id } }); 
        },

        getCurrentRouteName() {
            this.currentRouteName = this.$router.currentRoute.name;
        },

        updateClientListState(id) {

            for(var li = 0; li < this.$refs.listItems.length; li++) {
                console.log(this.$refs.listItems[li]);
                if(this.$refs.listItems[li].id == id) { 
                    if(this.prevSelected != null) {
                        this.prevSelected.css('backgroundColor', '#7A8088');
                    }
                    this.prevSelected = $(this.$refs.listItems[li]);
                    $(this.$refs.listItems[li]).css('backgroundColor', '#3E4652');
                }
            }

         
        }
    },
}
</script>

<style scoped>

.clients-list {

    overflow: auto;
    margin: 0;
    padding: 0;
    color:white;
    font-size: 17px;
    list-style: none;
}

.clients-list li {
    padding: 10px 10px 10px 30px;
}
.clients-list li:hover {
  color:#D2D4DA !important;
  cursor: pointer;
}

.active {
    background: #3E4652;
}

</style>
