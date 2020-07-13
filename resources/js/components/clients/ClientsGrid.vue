<template>
    <div class="row p-5  clients-grid">
        <div  v-for="(client, index) in clients" :key="'cg-'+client.id" @click="showClientDetails(client)" class="col-sm-2 text-center grid-item">
            <!-- <span class="dot mt-3 mb-1"></span> -->
               <img style=" border-radius: 50%;" class="mt-3" :src="'/images/'+client.profile_pic" 
                    width="100" height="100" :alt="client.name"> 
            <div>
                {{client.name}}
               
            </div>
        </div>
    </div>
</template>

<script>
export default {
    components: {

    },
    created() {
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

        

    },
    data() {
        return {
            baseUrl: '/api/',
            clients: []
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
            Fire.$emit('onUpdateClientListState', client.id); 
            this.$router.push({ name: 'clientDetails', params: { id: client.id } }); 
        }
    }
}
</script>

<style scoped>

.grid-item {
    border: 1px solid #D5D7DB;
    padding: 10px;
    margin-right: 8px;
    margin-top: 8px;
    font-size: 17px;
    color: #9399A6;
    background: white;
}

.grid-item:hover {
    cursor: pointer;
}

 .dot {
    height: 100px;
    width: 100px;
    background-color: #9399A6;
    border-radius: 50%;
    display: inline-block;
  }


</style>
