<template>
    <div>
         <EditingTime></EditingTime>
         <div class="container-fluid" style="padding:0;margin:0">
           <div class="row">

            <div class="col-sm-2 side-panel">
              
              <create-project :isTimeTrackingRoute="isTimeTrackingRoute"></create-project>

              <!-- Projects List -->
              <hr style="margin-right:15px;margin-left:15px">
              <h4 class="projects-list-header noselect" @click.self="showProjectsList">Projects &nbsp; <i @click.self="showProjectsList" class="fas fa-caret-down"></i></h4>
              <hr style="margin-right:15px;margin-left:15px">

              <ProjectsList v-show="isShowProjectsList"></ProjectsList>

              <!-- Clients List -->
              <hr style="margin-right:15px;margin-left:15px">
              <h4  class="clients-list-header noselect" @click.self="showClientsList" >Clients &nbsp;  <i @click.self="showClientsList" class="fas fa-caret-down"></i> </h4>
              <hr style="margin-right:15px;margin-left:15px">
              <ClientsList v-show="isShowClientList"></ClientsList>
         
            </div>

            <!-- Main Contents -->
            <div class="col-sm-10 main-content" >

                <!-- Clients Grid -->
                <router-view></router-view>

            </div>
             <!-- // END Main Contents -->
           </div>
         </div>
         
    </div>
</template>

<script>

import EditingTime from './EditingTime';
import ClientsList from '../clients/ClientsList';
import ProjectsList from '../projects/ProjectsList.vue'

export default {
    components: {
        ClientsList,
        ProjectsList,
        EditingTime
    },
    created() {
      
    },
    beforeUpdate() { 
      
   },
    data() {
      return {
        isShowClientList: false,
        isShowProjectsList: false,
        isTimeTrackingRoute: true,
      };
    },
    methods: {

      showClientsList() {
        if(this.isShowClientList) {
          this.isShowClientList = false;
          return;
        }

        this.isShowProjectsList = false;
        this.isShowClientList = true;
      },

      showProjectsList() {
        if(this.isShowProjectsList) {
          this.isShowProjectsList = false;
          return;
        }

        this.isShowClientList = false;
        this.isShowProjectsList = true;

      }
      
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
  background: #32383F;
  border-left: 1px solid#9399A6;
}

.clients-list-header {
  color:#fff;
  text-align:center;
}

.clients-list-header:hover{
  cursor: pointer;
  color: #D2D4DA;
}

.projects-list-header {
  color: #fff;
  text-align:center;
}

.projects-list-header:hover {
  cursor: pointer;
  color: #D2D4DA;
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
