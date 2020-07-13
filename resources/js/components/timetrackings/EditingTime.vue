<template>
    <div>
     
           <!-- Edit Time Modal -->
        <div  class="modal fade" id="edit-time-modal" tabindex="-1" role="dialog" aria-labelledby="edit-time-modalCenterTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="edit-time-modalLongTitle">  Edit Time </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <form @submit.prevent="save">
                    <div   class="modal-body">

                     <div class="container-fluid">
                          <div  class="row">
                            <div class="col-sm-12">


                              <!-- Choose Clients Selection -->
                              <div class="form-group">
                                
                                <select disabled style="width:100%;padding:7px;" name="client_id">
                                  <option value="0" selected >{{clientName}}</option>
                                </select>
                              </div>

                              <!-- Project Name -->
                              <div class="form-group">
                                <input type="text" name="project_name"
                                  placeholder="Project Name" disabled
                                  class="form-control" :value="projectName">
                                
                              </div>

                              <hr>
                              <div class="row">
                                <div class="col-sm-12">
                                  <p> Time Management </p>
                                  
                                </div>
                              </div>

                              
                              <div class="row">
                                <div class="col-sm-4">
                                 
                                <!-- My Start Time -->
                                <label for="start_time ">Start Time</label>
                                <input name="start_time" v-model="form.start_time" type="time">
                           
                                </div>
                                <div class="col-sm-4">
                                     
                                     <!-- End time -->
                                     <label for="end_time">End Time</label> <br/>
                                     <input name="end_time" type="time" v-model="form.end_time">

                                </div>

                                <div class="col-sm-4">
                                    <!-- Total timeSpent -->
                                     <label for="total-time">Total Time Spent</label> <br/>
                                     <span id="total-time"> 12s </span>
                                      
                                </div>


                              </div>

                               <hr>
                               <div class="row mt-3">
                                <div class="col-sm-12">
                                  <p> Add Notes </p>
                                  
                                </div>
                              </div>

                              <div class="row">
                                <div class="col-sm-12">
                                  <!-- Notes -->
                                  
                                  <div class="form-group mt-2">
                                  
                                    <textarea placeholder="Project Time Tracking Notes..." name="notes" v-model="form.notes" class="form-control"  :class="{ 'is-invalid': form.errors.has('notes') }" id="notes" rows="8"></textarea>
                                    <has-error :form="form" field="notes"></has-error>
                                  </div>
                                </div>
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
      Fire.$on('onStartEditingTime', (project) => {
        this.startEditingTime(project);
      });
  },

  data() {
    return {
      baseUrl: '/api/',
      modalBtnLabel: 'Save',
      clientName: '',
      projectName: '',
      
      form: new Form({
          id: 0,
          start_time: 0,
          end_time: 0,
          total_time_spent: 0,
          notes: ' ',
          project_id: 0
      }),
    };
  },
  methods: {
    getCurrentRouteName() {
      this.currentRouteName = this.$router.currentRoute.name;
    },
    startEditingTime(project) {
      this.clientName = project.client.name;
      this.projectName = project.project_name;
      this.form.project_id = project.id;
      console.log(project);
    },

    save() {
        this.$Progress.start();
          this.form.post(this.baseUrl + 'TimeTracking').
          then(({data})=>{
            if(data.success) {
                this.$Progress.finish();
                $('#edit-time-modal').modal('hide');
                 
                Fire.$emit('onEditedTime');
            }
          }).catch(({data})=> {
            this.$Progress.fail();
      });
    },

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
