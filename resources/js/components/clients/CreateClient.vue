<template>
    <div>
        <div class="head text-center p-3">
            <h3 style="color:white">Clients</h3>
            <button @click="startCreateNewClient" class="btn  btn-block new-client-btn" data-toggle="modal" data-target="#main-modal">New Client</button>
        </div>

           <!-- Main Modal -->
        <div  class="modal fade" id="main-modal" tabindex="-1" role="dialog" aria-labelledby="main-modalCenterTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="main-modalLongTitle"> {{createClientBtnLabel}}  </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <form @submit.prevent="isUpdateMode ? updateClient() : addNewClient()">
                    <div   class="modal-body">


                     <div class="container-fluid">
                          <div class="row">
                            <div class="col-sm-7" >
                              
                              <!-- Username -->
                              <div class="form-group">
                                <input v-model="form.name" type="text" name="name"
                                  placeholder="Client Name"
                                  class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                                <has-error :form="form" field="name"></has-error>
                              </div>

                            

                              <!-- Master Data -->
                              <div class="form-group">
                                <textarea placeholder="Master Data..." name="master_data" v-model="form.master_data" class="form-control"  :class="{ 'is-invalid': form.errors.has('master_data') }" id="master_data" rows="9"></textarea>
                                <has-error :form="form" field="master_data"></has-error>
                              </div>

                              <!-- Notes -->
                              <div class="form-group">
                                <textarea placeholder="Notes..." name="notes" v-model="form.notes" class="form-control"  :class="{ 'is-invalid': form.errors.has('notes') }" id="notes" rows="8"></textarea>
                                <has-error :form="form" field="notes"></has-error>
                              </div>
  
                            </div>  

                            <div class="col-sm-5">
                       
                                <!-- Contact info -->
                                   <div class="nav shadow-sm p-3 mb-1 bg-white contact-container">
                                  
                                    <span class="noselect" style="margin:0px auto" @click.self="showClientContactForm">&nbsp;&nbsp;
                                      {{ contactUpdateMode ? "Update" : "Add" }} Client Contact &nbsp;
                                      <i @click.self="showClientContactForm" class="fas fa-caret-down"></i> 
                                    </span> 

                                    <hr v-show="isShowTBorder" class="t-border">

                                    <ul class="shadow-lg p-3 mb-1 bg-white rounded contact-form"  v-show="isShowClientContactForm" >
                                            <div class="form-group">
                                              <input v-model="contact.first_name" type="text" name="first_name"
                                                placeholder="First Name"
                                                class="form-control" >
                    
                                            </div>

                                        <div class="form-group">
                                          <input v-model="contact.last_name" type="text" name="last_name"
                                            placeholder="Last Name"
                                            class="form-control" >
                                        
                                        </div>

                                        <div class="form-group">
                                          <input v-model="contact.email" type="email" name="email"
                                            placeholder="Client Email Address"
                                            class="form-control" >
                                        
                                        </div>

                                        <div class="form-group">
                                          <input v-model="contact.phone" type="text" name="phone"
                                            placeholder="Client Phone #"
                                            class="form-control" >
                                        </div>
                                          <hr>
                                           <button @click.self="hideClientContactForm" type="button" class="btn copy-client-btn btn-sm">Cancel</button>
                                           
                                           <button type="button" v-if="!contactUpdateMode" @click="addContactToList" class="btn new-client-btn btn-sm"> Add Contact </button>
                                           <button type="button" v-if="contactUpdateMode" @click="updateContact" class="btn new-client-btn btn-sm"> Update Contact </button>
                                      </ul>

                                  </div>

                                 <ul  v-show="form.contacts.length > 0 ?  true : false" class="contacts-list mt-3">
                                   
                                    <li v-for="(contact, index) in form.contacts" :key="index">
                                          
                                        <div class="container-fluid" style="margin:0;padding:0">
                                          <div class="row">
                                            <div class="col-sm-1" style="margin:8px 3px;">
                                                <span class="remove" style="font-weight:bold" @click="removeContactFromList(index)"> X </span> &nbsp;
                                            </div>
                                            <div class="col-sm-10">
                                             

                                                <div class="row shadow-none p-2   bg-light rounded">
                                                  <div class="col-sm-7">
                                                    {{ contact.first_name + ' ' + contact.last_name }}
                                                  </div>
                                                  <div class="col-sm-1">
                                               <button type="button" @click="editContact(index, contact)" class="btn btn-sm new-client-btn">edit</button>
                                            </div>
                                                </div>

                                            </div>
                                            
                                          </div>
                                        </div>
                                          
                                           
                                          
                                        
                                           
                                          
                                    </li>
                                </ul>
                              
                                <!-- Products -->

                                  <div class="nav shadow-sm p-3 mb-1 bg-white products-container ">
                                  
                                    <span class="noselect" style="margin:0px auto"  @click.self="showProducts">&nbsp;&nbsp;
                                      Products &nbsp;
                                      <i @click.self="showProducts" class="fas fa-caret-down"></i> 
                                    </span> 

                                    <hr v-show="isShowTProductsBorder" class="t-border">

                                    <ul class="shadow-lg p-3  mb-1 bg-white rounded products"  v-show="isShowProducts" >
                                            
                                          <li  class="noselect product" v-for="(product, index) in products" :key="'p-'+product.id" @click="addProductToList(product)">
                                            {{product.name}}
                                          </li>

                                          <hr>
                                           <button @click.self="hideProducts" type="button" class="btn copy-client-btn btn-sm">Close</button>
                                           
                                      </ul>

                                  </div>

                                  <ul  v-show="form.products.length > 0 ?  true : false" class="products-list mt-3">
                                   
                                    <li v-for="(product, index) in form.products" :key="'pl-'+index">
                                          
                                       
                                          <div class="row">
                                            <div class="col-sm-1" style="margin:8px 3px;">
                                                <span class="remove" style="font-weight:bold" @click="removeProductFromList(index)"> X </span>
                                            </div>
                                            <div class="col-sm-10">
                                             

                                                <div class="shadow-none p-2 mb-1  bg-light rounded">
                                                  {{ product.name }}
                                                
                                                </div>

                                            </div>
                                            
                                          </div>
                                       

                                     </li>
                                </ul>

                                  <!-- Upload Client Profile -->
                              
                              <div class="form-group mt-5">
                                <hr>
                                <label for="pic">Upload client profile picture:</label> <br>
                                <input id="pic" @change="updateProfilePic" type="file" name="pic" >
                              </div>

                              <div class="mb-1" id="profile-pic"></div>


                            </div>

                          </div> 
                     </div>   


                
                  </div>
                    <div class="modal-footer">
                      <button type="button" class="btn copy-client-btn" data-dismiss="modal">Close</button>
                      <button id="createClientBtn" type="submit" class="btn new-client-btn"> {{ isUpdateMode ? "Update Client" : "Add New Client" }} </button>
                    </div>
                   </form>
              </div>
              
            </div>
          </div>
        </div>


    </div>
</template>

<script>
export default {
    components: {
    
  },
  created() {
     console.log("createClient: created");
    this.getProducts();
      Fire.$on('onStartUpdateClient', (client) => {
        this.startUpdateClient(client);
      });

      Fire.$on('onConfirmStartDeleteClient', (client) => {
        this.deleteClient(client);
      });

      Fire.$on('onStartCopyClient', (client) => {
        this.startCopyClient(client);
      });

      this.image.id = 'profile-pic';
        $(this.image).css('borderRadius','50%');
     
  },
  data() {
    return {
      baseUrl: '/api/',
      isShowTBorder: false,
      isShowClientContactForm: false,
      contactUpdateMode: false,
      isShowTProductsBorder: false,
      isShowProducts: false,
      createClientBtnLabel: 'New Client',
      image: new Image(),
      products: [],
      contact: {
            index: 0,
            first_name: '',
            last_name: '',
            email: '',
            phone: '',
      },
       form: new Form({
            id: 0,
            name: '',
            profile_pic: '',
            master_data: '',
            notes: '',
            contacts: [],
            products: [],
          
          }),
          isUpdateMode: false,
    };
  },
  methods: {
    getProducts() {
      this.$Progress.start();
        axios.get(this.baseUrl + 'product')
        .then(({data})=>{
            if(data.success) {
              this.$Progress.finish();
                this.products = data.products;
                console.log(this.products);
            }
        }).catch(({data})=> {
            this.$Progress.fail();
        });
    },
    addNewClient() {
          $('#createClientBtn').attr("disabled", true);
          this.$Progress.start();
        this.form.post(this.baseUrl + 'client')
        .then(({data}) => {
              if(data.success) {
                 $('#createClientBtn').attr("disabled", false);
                $('#main-modal').modal('hide');
                //this.getClients();
                this.$Progress.finish();
                Fire.$emit('onClientCreated');

              }
        })
        .catch(({data})=>{
           $('#createClientBtn').attr("disabled", false);
           this.$Progress.fail();
        });
    },
    startUpdateClient(client) {
       this.image.src = null;
          $('#pic').val('');
      $(this.image).css('display','none');
      this.createClientBtnLabel = 'Update Client';
      this.isUpdateMode = true;
      this.form.id = client.id;
      console.log(client);
      this.form.copyMode = false;
      this.form.products = [];
      this.form.contacts = [];
      this.contact.index = 0;
      this.contact.first_name =  "";
      this.contact.last_name =  "";
      this.contact.email =  "";
      this.contact.phone =  "";
      this.form.name = "";
      this.form.profile_pic = "";
      this.form.master_data = "";
      this.form.notes = "";

      if(client.clientChosenProducts != undefined) {
        this.form.products = client.clientChosenProducts;
      }

      if(client.contacts != undefined) {
        this.form.contacts = client.contacts; 
      }

      this.form.name = client.name;
      this.form.profile_pic = client.profile_pic;
      this.form.master_data = client.master_data;
      this.form.notes = client.notes;
      


   
    },
    updateClient() {
      console.log("Update Client: " + this.form.id);
      this.$Progress.start();
        this.form.put(this.baseUrl + 'client/' + this.form.id)
        .then(({data}) => {
              if(data.success) {
                $('#main-modal').modal('hide');
                
                this.$Progress.finish();
                Fire.$emit('onClientUpdated');

              }
        })
        .catch(({data})=>{
          this.$Progress.fail();
        });
        
    },
    deleteClient(client) {
        console.log('delete client: ' + client.id);
        this.$Progress.start();
        axios.delete(this.baseUrl + 'client/' + client.id)
        .then(({data})=>{
            if(data.success) {
              this.$Progress.finish();
              $('#dialog').modal('hide');
               Fire.$emit('onClientDeleted');
            }
        }).catch(({data})=>{
          this.$Progress.fail();
        });

    },
    addProductToList(product) {
      this.hideProducts();
      for(var p = 0; p < this.form.products.length; p++) {
         if(this.form.products[p].id == product.id){
          return;
        }
      }
      
      this.form.products.push(_.cloneDeep(product));
    },
    removeProductFromList(index) {
       this.form.products.splice(index, 1);
    },
    addContactToList() {
      this.form.contacts.push(_.cloneDeep(this.contact));
       this.hideClientContactForm();
    },
    removeContactFromList(index) {
      this.form.contacts.splice(index, 1);
    },
    updateContact() {
      this.form.contacts.splice(this.contact.index, 1, _.cloneDeep(this.contact) );
      this.hideClientContactForm();
    },
    editContact(index,contact) {
      this.contact.index = index;
      this.contact.first_name =  contact.first_name;
      this.contact.last_name =  contact.last_name;
      this.contact.email =  contact.email;
      this.contact.phone =  contact.phone;

      this.isShowClientContactForm = true;
      this.isShowTBorder = true;
      this.contactUpdateMode = true;
       
    },
    showProducts() {
       if(!this.isShowProducts) {
                this.isShowProducts = true;
                this.isShowTProductsBorder = true;  
            } else {
                this.isShowProducts = false;
                this.isShowTProductsBorder = false;
            }
    },
    hideProducts() {
        this.isShowProducts = false;
        this.isShowTProductsBorder = false;
    },
    showClientContactForm() {

      this.contact.index = 0;
      this.contact.first_name =  "";
      this.contact.last_name =  "";
      this.contact.email =  "";
      this.contact.phone =  "";


       if(!this.isShowClientContactForm) {
                this.isShowClientContactForm = true;
                this.isShowTBorder = true;  
            } else {
                   this.isShowClientContactForm = false;
           this.isShowTBorder = false;
            }
    },
    hideClientContactForm() {
      this.contact.index = 0;
      this.contact.first_name =  "";
      this.contact.last_name =  "";
      this.contact.email =  "";
      this.contact.phone =  "";
          this.isShowClientContactForm = false;
          this.isShowTBorder = false;
          this.contactUpdateMode = false;
    },
    startCreateNewClient() {
          this.image.src = null;
        $('#pic').val('');
      $(this.image).css('display','none');
        this.form.copyMode = false;
      this.createClientBtnLabel = 'New Client';
      this.isUpdateMode = false;
      this.form.products = [];
      this.form.contacts = [];
      this.contact.index = 0;
      this.contact.first_name =  "";
      this.contact.last_name =  "";
      this.contact.email =  "";
      this.contact.phone =  "";
      this.form.profile_pic = "";
      this.form.name = "";
      this.form.master_data = "";
      this.form.notes = "";
     
    },
    startCopyClient(client) {
        $('#pic').val('');
      this.image.src = null;
      $(this.image).css('display','none');  
      this.createClientBtnLabel = 'Copy Client';
      this.isUpdateMode = false;
      this.form.id = 0;
      this.form.products = [];
      this.form.contacts = [];
      this.contact.index = 0;
      this.contact.first_name =  "";
      this.contact.last_name =  "";
      this.contact.email =  "";
      this.contact.phone =  "";
     
      this.form.name = "";
      this.form.profile_pic = "";
      this.form.master_data = "";
      this.form.notes = "";

      if(client.clientChosenProducts != undefined) {
        this.form.products = client.clientChosenProducts;
      }

      if(client.contacts != undefined) {
        this.form.contacts = client.contacts; 
      }

      this.form.name = "copied_" + client.name;
      this.form.profile_pic = 'profile-placeholder.png';
      this.form.master_data = client.master_data;
      this.form.notes = client.notes;
      this.form.copyMode = true;
    },
    updateProfilePic(event) {
      var profilePic = event.target.files[0];
      
      var reader = new FileReader();
      reader.onloadend = () => {
        console.log('RESULT', reader.result);
        this.form.profile_pic = reader.result;
        this.image.src = reader.result;
        this.image.width = 100;
        this.image.height = 100;
        $('#profile-pic').empty();
        $('#profile-pic').append(this.image);
         $(this.image).css('display','block');
      
      } 
      reader.readAsDataURL(profilePic);
      
    }
  }
}
</script>

<style scoped>

.new-client-btn {
    color: white;
    border-color: #9399A6;
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


@media (min-width: 576px) {
.modal-dialog {
    max-width: 800px;
    margin: 1.75rem auto;
}
}

.t-border {
    margin: 0px;
    margin-top: 8px;
    width: 275px; 
    border-width: 4px;
    background:  #9399A6;
 }
    
.contact-container,.products-container  {
    height: 62px;
    text-align: center; 
    position: relative;
}

 .contact-container span:hover, .products-container span:hover {
    color: #9399A6;
    cursor: pointer;
        
} 

.contact-container .contact-form, .products-container .products{
    position: absolute;
    left: 0px;
    text-align: left;
    top:50px;
    width: 275px; 
    z-index: 110;
}

.products-container .products{
  z-index: 100;
}

.products-container .products li {
    width: 100px;
    display: inline-block;
    text-align: center;
    padding-top: 15px;
    
}


.contacts-list,.products-list {
    list-style: none;
    margin: 0;
    padding: 0px;
}

.product:hover{
    color:#9399A6;
    cursor: pointer;
}

.remove{
    font-weight: bolder;
}

.remove:hover {
    color: red;
    cursor: pointer;
}

.noselect {
  -webkit-touch-callout: none; /* iOS Safari */
    -webkit-user-select: none; /* Safari */
     -khtml-user-select: none; /* Konqueror HTML */
       -moz-user-select: none; /* Firefox */
        -ms-user-select: none; /* Internet Explorer/Edge */
            user-select: none; /* Non-prefixed version, currently
                                  supported by Chrome and Opera */
}



</style>
