<template>
    <div>
        <div class="container-fluid p-5">
            <!-- header -->
            <div class="row header">
                <div class="col-sm-2 img text-center">
                    <!-- <span class="dot mt-3 mb-3 "> </span> -->
                     <img style=" border-radius: 50%;" class="mt-3" :src="'/images/'+client.profile_pic" 
                    width="100" height="100" :alt="client.name"> 
                </div>
                <div class="col-sm-10">
                     <div class="row">
                         <div class="col-sm-10 name">
                             <h1 style="color:#3E4652">{{client.name}}</h1>
                         </div>
                         <div class="col-sm-2 edit-bar">
                            <button @click="startUpdateClient" class="btn  mt-2  btn-block new-client-btn" data-toggle="modal" data-target="#main-modal">Edit</button>
                         </div>
                     </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-8">
                    <div class="row">

                        <!-- master Data -->
                         <div class="col-sm-6 master-data-h">
                            <h2 style="color:#3E4652">Master Data</h2>
                        </div>

                         <div class="col-sm-6 products-h">
                            <h2 style="color:#3E4652">Products</h2>
                         </div>
                         <div class="col-sm-6 master-data-d">
                            <pre style="white-space: pre-wrap;">{{client.master_data}}</pre>
                        </div>

                        <div class="col-sm-6 products-d">
                            <p v-for="product in client.clientChosenProducts" :key="product.id">
                                {{product.name}}
                            </p>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-sm-12 notes-h">
                            <h2 style="color:#3E4652">Notes</h2>
                        </div>
                         <div class="col-sm-12 notes-d">
                           <pre style="white-space: pre-wrap;">{{client.notes}}</pre>
                        </div>
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="row">
                        <div class="col-sm-12 contacts-h">
                            <h2 style="color:#3E4652">Contacts</h2>
                        </div>
                        <div class="col-sm-12 contacts-d" v-for="contact in client.contacts" :key="contact.id">
                           <div>
                               <p>{{ contact.first_name + ' ' + contact.last_name }}</p>
                               <p> {{ contact.email }}</p>
                               <p>{{contact.phone}}</p>
                           </div>
                        </div>
                        
                        
                    </div>
                </div>

            </div>

              <div class="row mt-4">
                <div class="col-sm-6">
                   
                     <button @click="backToClientsGrid" class="btn  pl-3 pr-3 mt-2 copy-client-btn" > <i class="fas fa-long-arrow-alt-left"></i>  Back </button>
                </div>
                <div class="col-sm-6 text-right">
                    <button @click="startCopyClient" class="btn   pr-3 mt-2 copy-client-btn" data-toggle="modal" data-target="#main-modal">Copy Client</button>
                    <button @click="startDeleteClient" class="btn  pl-3 pr-3 mt-2 new-client-btn" data-toggle="modal" data-target="#dialog">Delete</button>
                </div>
            </div>

        </div>

    </div>
</template>

<script>
export default {
    props: ['id'],
    watch: {
        '$route.params.id': function (id) {
           this.getClientDetails();
        }
      },
    created() {
        this.getClientDetails();

        Fire.$on('onClientUpdated', () => {
            this.getClientDetails();
        });
        Fire.$on('onClientDeleted', () => {
            this.$router.push({ name: 'clients' }); 
        });
    },
    beforeUpdate() {
        
    },
    data() {
        return {
            baseUrl: '/api/',
            client: {},
        };
    },
    methods: {
      getClientDetails(id) {
          this.$Progress.start();
          console.log('get client det');
          axios.get(this.baseUrl + 'client/getClientDetails/' + this.id)
          .then(({data}) => {
              if(data.success) {
                   this.$Progress.finish();
                  this.client = data.client;
                  console.log(this.client);
              }
          });
          
      },
      backToClientsGrid() {
          this.$router.push({ name: 'clients' }); 
      },
      startUpdateClient() {
        Fire.$emit('onStartUpdateClient', _.cloneDeep(this.client));
      },
      startDeleteClient() {
          Fire.$emit('onStartDeleteClient', _.cloneDeep(this.client));
      },
      startCopyClient() {
          Fire.$emit('onStartCopyClient', _.cloneDeep(this.client));
      }
    }
}
</script>

<style scoped>

 .dot {
    height: 100px;
    width: 100px;
    background-color: #9399A6;
    border-radius: 50%;
    display: inline-block;
}

.name {
    padding-top: 38px;
    padding-bottom: 40px;
}

.name h1 {
    font-size: 45px;
}

.new-client-btn {
    
    color: white;
    background: #535B67;
    border-color: #9399A6;
}

.edit-bar {
    padding-top: 38px;
}
.new-client-btn:hover {
   background: #3E4652;
}

.copy-client-btn {
    font-weight: bold;
    color:  #535B67;
    background: white;
    border-color: #9399A6;
}

.copy-client-btn:hover {
   color:white;
   background: #9399A6;
}

.img {
       height: 140px;
       border-left: 1px solid #D5D7DB;
       border-top: 1px solid #D5D7DB;
       border-bottom: 1px solid #D5D7DB;
}

.name {
    height: 140px;
    border-left: 1px solid #D5D7DB;
    border-top: 1px solid #D5D7DB;
    border-bottom: 1px solid #D5D7DB;
}
.edit-bar {
   
    border-top: 1px solid #D5D7DB;
    border-bottom: 1px solid #D5D7DB;
    border-right: 1px solid #D5D7DB;
}


.master-data-h {
    background: white;
    height: 80px;
    padding-top: 22px;
    border-left: 1px solid #D5D7DB;
    border-bottom: 1px solid #D5D7DB;
}

.products-h{
    background: white;
    padding-top: 22px;
    border-left: 1px solid #D5D7DB;
    border-bottom: 1px solid #D5D7DB;
    border-right: 1px solid #D5D7DB;
   
}

.contacts-h {
    background: white;
    padding-top: 22px;
      height: 80px;
    border-left: 1px solid #D5D7DB;
    border-bottom: 1px solid #D5D7DB;
    border-right: 1px solid #D5D7DB;
}

.notes-h{
    background: white;
    padding-top: 22px;
    height: 80px;
    border-left: 1px solid #D5D7DB;
    border-bottom: 1px solid #D5D7DB;
    border-right: 1px solid #D5D7DB;
   
 
}

.master-data-d {
    background: white;
    padding-top: 10px;
    font-size: 17px;
    padding-left: 20px;
    border-left: 1px solid #D5D7DB;
    border-bottom: 1px solid #D5D7DB;
}

.products-d {
    background: white;
    padding-top: 10px;
    font-size: 17px;
    padding-left: 20px;
    border-left: 1px solid #D5D7DB;
    border-bottom: 1px solid #D5D7DB;
    border-right: 1px solid #D5D7DB;
   
}

.notes-d {
    background: white;
    padding-top: 10px;
    font-size: 17px;
    padding-left: 20px;
    border-left: 1px solid #D5D7DB;
    border-bottom: 1px solid #D5D7DB;
    border-right: 1px solid #D5D7DB;
}

.contacts-d {
    background: white;
    padding-top: 10px;
    font-size: 17px;
    padding-left: 20px;
    border-left: 1px solid #D5D7DB;
    border-bottom: 1px solid #D5D7DB;
     border-right: 1px solid #D5D7DB;
}




  [v-cloak] {
        display: none;
    }

</style>
