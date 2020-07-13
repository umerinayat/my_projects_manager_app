<template>
    <div>
        <Dialog></Dialog>
       <div class="container-fluid" style="padding:0;margin:0">
           <div class="row">

            <div class="col-sm-2 side-panel" >
              <!-- Clients List -->
              
              <create-client></create-client>
              <ClientsList></ClientsList>
            </div>

            <!-- Main Contents -->
            <div class="col-sm-8 main-content" >

                <!-- Clients Grid -->
                <ClientsGrid v-show="isShowClientsGrid && currentRouteName !== 'clientDetails'"></ClientsGrid>
                <router-view></router-view>

            </div>
             <!-- // END Main Contents -->

              <!-- products filter -->
            <div class="col-sm-2 p-5 products-filter">
                
                <ProductsFilterList></ProductsFilterList>

            </div>
             <!-- // END products filter -->
            
           </div>

       </div>



    </div>
</template>

<script>

import ClientsList from './ClientsList';
import ClientsGrid from './ClientsGrid';
import Dialog from './Dialog.vue';
import CreateClient from './CreateClient.vue';
import ProductsFilterList from './ProductsFilterList';

export default {
  components: {
    CreateClient,
    Dialog,
    ClientsList,
    ClientsGrid,
    ProductsFilterList
  },
  created() {
    console.log('client created');
    this.getCurrentRouteName();
  },
  beforeMount() {
    console.log('beforeMount');
  },
  mounted() {
     console.log('mounted');
  },
  beforeUpdate() {
    this.getCurrentRouteName();
    if(this.currentRouteName === 'clientDetails') {
       this.isShowClientsGrid = false;
    } else {
      this.isShowClientsGrid = true;
    }
      

     console.log('beforeUpdate');
  },
  updated() {
      console.log('updated');
  },

  data() {
    return {
      baseUrl: '/api/',
      currentRouteName: "",
      isShowClientsGrid: true

    };
  },
  methods: {
    getCurrentRouteName() {
      this.currentRouteName = this.$router.currentRoute.name;
    },
  }

}
</script>

<style scoped>

.side-panel{
  padding:0;margin:0;height:880px; background: #7A8088;
  overflow: auto;
}

.main-content {
  background: #EDEFF3;
  height:880px;
  overflow: auto;
}

.products-filter {
  background: #EDEFF3;
  border-left: 1px solid#9399A6;
}

  
</style>
