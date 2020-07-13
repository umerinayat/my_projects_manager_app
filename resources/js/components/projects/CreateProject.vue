<template>
    <div>
        <div class="head text-center p-3">
            <h3 style="color:white"> {{ isTimeTrackingRoute ? 'Time Tracking' : 'Projects' }} </h3>
            <button @click="startCreatingNewProject" class="btn  btn-block new-btn" data-toggle="modal" data-target="#new-project-modal"> {{  isTimeTrackingRoute ? 'New' : 'New Project'  }}</button>
        </div>

        <!-- Main Modal -->
        <div  class="modal fade" id="new-project-modal" tabindex="-1" role="dialog" aria-labelledby="new-project-modalCenterTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="new-project-modalLongTitle">  {{  isTimeTrackingRoute ? 'New Time Tracking' : modalBtnLabel  }} </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <form @submit.prevent="handleProjectActions">
                    <div   class="modal-body">

                     <div class="container-fluid">
                          <div v-show="!isProjectMovingMode" class="row">
                            <div class="col-sm-12">


                              <!-- Choose Clients Selection -->
                              <div class="form-group">
                                

                                <select style="width:100%;padding:7px;" name="client_id" v-model="form.client_id">
                                  <option value="0" disabled>Choose Client...</option>
                                  <option v-for="(client, index) in clients" :key="'c'+client.id" :value="client.id">
                                    {{client.name}}
                                  </option>
                                </select>
                              </div>

                              <!-- Project Name -->
                              <div class="form-group">
                                <input v-model="form.project_name" type="text" name="project_name"
                                  placeholder="Project Name"
                                  class="form-control" :class="{ 'is-invalid': form.errors.has('project_name') }">
                                <has-error :form="form" field="project_name"></has-error>
                              </div>

                              <!-- Project Description -->
                              <div class="form-group">
                                <textarea placeholder="Project Description..." name="project_description" v-model="form.project_description" class="form-control" 
                                 :class="{ 'is-invalid': form.errors.has('project_description') }" id="project_description" rows="8"></textarea>
                                <has-error :form="form" field="project_description"></has-error>
                              </div>

                              <div class="row">
                                <div class="col-sm-12">
                                  <p>Set due date and project priority.</p>
                                  <hr>
                                </div>
                              </div>

                              
                              <div class="row">
                                <div class="col-sm-4">
                                 
                                  
                                   <!-- Date -->
                                  <label for="due_date">Date</label>
                                  <input name="due_date" v-model="form.due_date" type="date">
                           
                                </div>
                                <div class="col-sm-3">
                                     
                                     <!-- Time -->
                                     <label for="due_time">Time</label> <br/>
                                     <input name="due_time" type="time" v-model="form.due_time">


                                </div>

                                <div class="col-sm-5">
                                      <!-- Priority -->
                                   <br>
                                       
                                  <div class="nav shadow-sm p-2 mb-1 bg-white priority-container">
                                  <hr v-show="isShowTPrioritiesBorder" class="t-border">
                                    <span class="noselect" style="margin:0px auto"  @click.self="showPriorities">&nbsp;&nbsp;
                                     <span @click.self="showPriorities" id="priority"> No Priority </span> &nbsp;
                                      <i @click.self="showPriorities" class="fas fa-caret-up"></i> 
                                    </span> 

                                

                                    <ul class="shadow-lg p-3  mb-1 bg-white rounded priorities"  v-show="isShowPriorities" >
                                            
                                          <li  class="noselect priority-name" v-for="(priority, index) in priorities" :key="'pri-'+index" @click="setPriority(priority)">
                                            {{priority.name}}
                                          </li>

                                          <hr>
                                           <button @click.self="hidePriorities" type="button" class="btn btn-outline-success btn-sm">Close</button>
                                           
                                      </ul>

                                  </div>
                                </div>


                              </div>


                              
                      
                            </div>  

                          
                          </div> 
                          <div v-show="isProjectMovingMode" class="row">
                               <div class="col-sm-12">
                                <!-- Choose Clients Selection for moving project -->
                                  <div class="mb-2" style="font-size:18px;">
                                    Move To:
                                  </div>
                                  <div class="form-group">
                                    

                                    <select style="width:100%;padding:7px;" name="id" v-model="form.id">
                                      <option value="0" disabled>Choose Client...</option>
                                      <option v-for="(client, index) in clients" :key="'c'+client.id" :value="client.id">
                                        {{client.name}}
                                      </option>
                                    </select>
                                  </div>
                               </div>
                          </div>
                     </div>   


                  </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Close</button>
                      <button type="submit" class="btn btn-outline-success"> {{ modalBtnLabel }} </button>
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
    props: ['isTimeTrackingRoute'],
    components: {
    
  },
  created() {
      
      this.getClients();
     
      Fire.$on('onStartUpdateProject', (project) => {
        this.startUpdateProject(project);
      });

      Fire.$on('onStartCopyProject', (project) => {
        this.startCopyProject(project);
      });

      Fire.$on('onStartMovingProject', (project) => {
        this.startMovingProject(project);
      });

      
      Fire.$on('onConfirmStartDeleteProject', (project) => {
        this.deleteProject(project);
      });


    
  },

  data() {
    return {
      baseUrl: '/api/',
      clients: [],
    
      priorities: [
        {
          name: 'No Priority',
        },
        {
          name: 'Low Priority',
        },
        {
          name: 'Medium Priority',
        },
        {
          name: 'High Priority',
        },
        {
          name: 'Urgent',
        },
        {
          name: 'Emergency',
        },

      ],
      modalBtnLabel: 'Add New Project',
      isShowPriorities:false,
      isShowTPrioritiesBorder: false,
      form: new Form({
          id: 0,
          project_name: '',
          project_description: '',
          label: 'No Priority',
          due_date: '',
          due_time: '',
          client_id: 0,
      }),
      moveProjectForm: new Form({
        client_id: 0
      }),  
      isProjectCreateMode: true,
      isUpdateMode: false,
      isProjectMovingMode: false,
    };
  },
  methods: {
    getCurrentRouteName() {
      this.currentRouteName = this.$router.currentRoute.name;

    

    },
    getClients() {
      this.$Progress.start();
      axios.get(this.baseUrl + 'client')
      .then(({data})=>{
          if(data.success) {
              this.$Progress.finish();
              this.clients = data.clients;
          }
      }).catch(({data})=> {
        this.$Progress.fail();
      });
    },
    handleProjectActions() {
      if(this.isUpdateMode) {
        this.updateProject();
        return;
      } 

      if(this.isProjectCreateMode) {
        this.addNewProject();
        return;
      }

      if(this.isProjectMovingMode) {
        this.moveProject();
        return;
      }
     
    },
    addNewProject() {
          this.$Progress.start();
          this.form.post(this.baseUrl + 'project').
          then(({data})=>{
            if(data.success) {
                this.$Progress.finish();
                $('#new-project-modal').modal('hide');

                Fire.$emit('onProjectCreated');
            }
          }).catch(({data})=> {
            this.$Progress.fail();
      });

    },
  
    updateProject() {
     
      this.$Progress.start();
        this.form.put(this.baseUrl + 'project/' + this.form.id)
        .then(({data}) => {
              if(data.success) {
                $('#new-project-modal').modal('hide');
                
                this.$Progress.finish();
                 Fire.$emit('onProjectUpdated');
                
              }
        })
        .catch(({data})=>{
          this.$Progress.fail();
        });
    },

    deleteProject(project) {
            this.$Progress.start();
            axios.delete(this.baseUrl + 'project/' + project.id)
            .then(({data})=>{
              if(data.success) {
                 this.$Progress.finish();
                 $('#dialog').modal('hide');
                 Fire.$emit('onProjectDeleted');
              }
            }).catch(({data})=>{
          this.$Progress.fail();
        });
    },
    moveProject() {
      console.log("Project Moved!");
       this.$Progress.start();
          this.form.post(this.baseUrl + 'project/moveProjectToClient').
          then(({data})=>{
            if(data.success) {
                this.$Progress.finish();
                $('#new-project-modal').modal('hide');
                Fire.$emit('onProjectMove');
            }
          }).catch(({data})=>{
          this.$Progress.fail();
        });
    },

    showPriorities() {
        if(!this.isShowPriorities) {
                this.isShowPriorities = true;
                this.isShowTPrioritiesBorder = true;  
            } else {
                this.isShowPriorities = false;
                this.isShowTPrioritiesBorder = false;
            }
    },

    hidePriorities() {
      this.isShowPriorities = false;
      this.isShowTPrioritiesBorder = false;
    },

    setPriority(priority) {

        this.form.label = priority.name;
        $('#priority').text(priority.name);

       this.hidePriorities();
    },

    startCreatingNewProject() {
        this.modalBtnLabel = 'Add New Project';
        this.isProjectCreateMode = true;
        this.isProjectMovingMode = false;
        this.isUpdateMode = false;
        this.form.project_name = '';
        this.form.project_description = '';
        this.form.label = 'No Priority';
        $('#priority').text('No Priority');
        this.form.due_date = '';
        this.form.due_time = '';
        this.form.client_id = 0;
    },
    startUpdateProject(project) {
        this.modalBtnLabel = 'Update Project';
        this.isProjectCreateMode = false;
        this.isProjectMovingMode = false;
        this.isUpdateMode = true;
        this.form.id = project.id;
        this.form.project_name = project.project_name;
        this.form.project_description = project.project_description;
        this.form.label = project.label;
        $('#priority').text(project.label);
        this.form.due_date = project.due_date;
        this.form.due_time = project.due_time;
        this.form.client_id = project.client_id;

    },

    startCopyProject(project) {
        this.modalBtnLabel = 'Copy Project';
        this.isProjectCreateMode = true;
        this.isProjectMovingMode = false;
        this.isUpdateMode = false;
        this.form.id = 0;
        this.form.project_name = "copied_"+project.project_name;
        this.form.project_description = project.project_description;
        this.form.label = project.label;
        $('#priority').text(project.label);
        this.form.due_date = project.due_date;
        this.form.due_time = project.due_time;
        this.form.client_id = project.client_id;
    },

    startMovingProject(project) {
      this.modalBtnLabel = 'Move Project';
      this.isProjectCreateMode = false;
      this.isProjectMovingMode = true;
      this.isUpdateMode = false;
      this.form.id = 0;
      this.form.project_name = project.project_name;
      this.form.project_description = project.project_description;
      this.form.label = project.label;
      $('#priority').text(project.label);
      this.form.due_date = project.due_date;
      this.form.due_time = project.due_time;
      this.form.client_id = project.client_id;

      console.log('start moving project');
    }

   
   
  }
}
</script>

<style scoped>

.t-border {
  position: absolute;
    left: 0;
    bottom: 40%;
    width: 100%; 
    border-width: 4px;
    background:  #9399A6;
 }

.new-btn {
    color: white;
    border-color: #9399A6;
}

.new-btn:hover {
   background: #3E4652;
}

@media (min-width: 576px) {
.modal-dialog {
    max-width: 600px;
    margin: 1.75rem auto;
}
}

.priority-container {
  position: relative;
}

.priority-container .priorities {
  position: absolute;
  left:0;
  text-align: center;
  width: 100%;
  bottom: 100%;
  list-style: none;
}

.priority-container .priorities li {
  padding: 5px;
  cursor: pointer;
}

.priority-container .priorities li:hover{
  color:darkolivegreen;
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
