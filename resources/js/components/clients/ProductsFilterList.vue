<template>
    <div>
        <h1 class="mb-2" style="color:#3E4652;font-weight:bold">Products</h1>
        <ul class="products-filter-list">
            <li ref="defSelected" @click="filterClientsByProduct(false)">All</li>
            <li @click="filterClientsByProduct(product)" v-for="product in products" :key="'pf-'+product.id">
                {{product.name}}
            </li>
        </ul>
    </div>
</template>

<script>
export default {
    components: {

    },
    created() {
        this.getProducts();
        

    },
    mounted() {
    
        this.prevSelected = $(this.$refs.defSelected);
        console.log(this.$refs.defSelected);
        this.prevSelected.css('color', '#3E4652');
        this.prevSelected.css('fontWeight', 'bold');
    },
    data() {
        return {
            baseUrl: '/api/',
            products: [],
           
            prevSelected: null
        };
    },
    methods: {
        getProducts() {
            axios.get(this.baseUrl + 'product')
            .then(({data})=>{
                if(data.success) {
                    this.products = data.products;
                    console.log(this.products);
                }
            });
        },
        filterClientsByProduct(product) {

            if(this.prevSelected != null) {
                 this.prevSelected.css('color', '#9399A6');
                 this.prevSelected.css('fontWeight', 'normal');
            }

            this.prevSelected = $(event.target);
            $(event.target).css('color', '#3E4652');
            $(event.target).css('fontWeight', 'bold');


            if(product) {
                 console.log('Filter Clients By Product: ' + product.id);
                 Fire.$emit('onFilterClientsByProduct', product);
            } else {
                console.log("all clients");
                Fire.$emit('onFilterClientsByProduct', false);
            }
           
        }
    }
}
</script>

<style scoped>

 .products-filter-list {
     list-style: none;
     margin: 0;
     padding: 0;
}

.products-filter-list li {
     margin-top: 8px;
     color: #9399A6;
     font-size: 17px;
}

.products-filter-list li:hover {
  color: #3E4652;
  cursor: pointer;
  
}




</style>
