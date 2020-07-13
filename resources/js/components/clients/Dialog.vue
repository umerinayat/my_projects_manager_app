<template>
    <div>
       
        <!-- Modal -->
        <div class="modal fade" id="dialog" tabindex="-1" role="dialog" aria-labelledby="dialogTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">
                    {{dialogTitle}}
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Are you sure you want to parmanently remove this {{ dialogMesg }}?
            </div>
            <div class="modal-footer">
                 <button type="button" class="btn btn-secondary" data-dismiss="modal">NO</button>
                 <button @click="hanldeResourceDeletion" type="button" class="btn btn-danger">YES</button>
               
               
            </div>
            </div>
        </div>
        </div>
    </div>
</template>

<script>
export default {
   data() {
       return {
           client: null,
           project: null,
           dialogTitle: '',
           dialogMesg: '',
           deleteMode: ''
       };
   },
   created() {
      Fire.$on('onStartDeleteClient', (client) => {
            this.dialogTitle=  'Delete Client';
            this.dialogMesg = 'client';
            this.deleteMode = 'CLIENT';
            this.client = client;
      });

      
      Fire.$on('onStartDeleteProject', (project) => {
            this.dialogTitle=  'Delete Project';
              this.dialogMesg = 'project';
            this.deleteMode = 'PROJECT';
            this.project = project;
      });
   },
   methods: {
       confirmStartDeleteClient() {
           Fire.$emit('onConfirmStartDeleteClient', _.cloneDeep(this.client));
       },

       confirmStartDeleteProject() {
           Fire.$emit('onConfirmStartDeleteProject', _.cloneDeep(this.project));
       },

       hanldeResourceDeletion() {
           switch(this.deleteMode) {
               case 'CLIENT':
                   this.confirmStartDeleteClient();
                   break;
                case 'PROJECT':
                    this.confirmStartDeleteProject();
                    break;
           }
       }
   }

}
</script>

<style scoped>
    .modal-title{
        font-weight: bold;
        color: #3E4652;
    }
    .modal-body {
        font-size: 18px;
        text-align: center;
        color: #3E4652;
        
    }
</style>
