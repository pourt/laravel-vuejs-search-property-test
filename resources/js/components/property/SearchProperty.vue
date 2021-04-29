<template>

    <el-row :gutter="6" class="p-2">

      <el-col :span="5">
        <el-card class="box-card">
          <el-form ref="form" :model="form" label-width="120px">

            <div class="block">
              <span class="">Search Property</span>
              <el-input  class="block"  v-model="form.keyword" @change="fitlerProperties()"></el-input>
            </div>

            <div class="block mt-2">
              <span class="">Price Range</span>
              <el-slider v-model="form.priceRange" range :max="form.maxPrice" @change="fitlerProperties"></el-slider>
            </div>

            <div class="block mt-2">
              <span class="">Bedrooms</span>
              <el-input  class="block"  v-model="form.bedrooms" @change="fitlerProperties()"></el-input>
            </div>

            <div class="block mt-2">
              <span class="">Bathrooms</span>
              <el-input  class="block"  v-model="form.bathrooms" @change="fitlerProperties()"></el-input>
            </div>

            <div class="block mt-2">
              <span class="">Storeys</span>
              <el-input  class="block"  v-model="form.storeys" @change="fitlerProperties()"></el-input>
            </div>

            <div class="block mt-2">
              <span class="">Garages</span>
              <el-input  class="block"  v-model="form.garages" @change="fitlerProperties()"></el-input>
            </div>

            <div class="block mt-2">
              <el-button class="w-100" type="primary" @click="fitlerProperties">Filter Properties</el-button>
            </div>

          </el-form>
        </el-card>
      </el-col>
      
      <el-col :span="19">
        <el-card class="box-card">
          <el-table
            :data="properties"
            v-loading="loading"
            element-loading-text="Loading..."
            element-loading-spinner="el-icon-loading"
            element-loading-background="rgba(0, 0, 0, 0.8)"
            empty-text="No properties found."
            style="width: 100%">
            <el-table-column
              prop="name"
              label="Name"
              width="180">
            </el-table-column>
            <el-table-column
              prop="price"
              label="Price"
              width="180">
            </el-table-column>
            <el-table-column
              prop="bedrooms"
              label="Bedrooms">
            </el-table-column>
            <el-table-column
              prop="bathrooms"
              label="Bathrooms">
            </el-table-column>
            <el-table-column
              prop="storeys"
              label="Storeys">
            </el-table-column>
            <el-table-column
              prop="garages"
              label="Garages">
            </el-table-column>
          </el-table>
        </el-card>
      </el-col>

  </el-row>

</template>

<script>
  export default {

    data () {
      return {
        properties: null,
        form: {
          keyword: null,
          priceRange: null,
          minPrice: 0,
          maxPrice: 0,
          bedrooms: null,
          bathrooms: null,
          storeys: null,
          garages: null
        },
        loading: true,
      }
    },

    mounted () {
      this.getProperties()

    },

    methods: {

      getProperties() {

        axios.get('/api/properties')
          .then((response) => {

          console.log('response', response);
          
          const {max_price, data} = response.data.property;

          this.properties = data
          this.form.priceRange = [0, max_price]
          this.form.maxPrice = max_price
          this.loading = false

        })
      },

      fitlerProperties () {

        this.loading = true

        const filterQuerty = this.filterParameters()

        axios.get(`/api/properties`,{
          params: filterQuerty
        })
          .then((response) => {
            this.properties = response.data.property.data
            this.loading = false
        })
      },

      filterParameters () {

        let queryParams = {}

        if (this.form.keyword !== "" ){
          queryParams["keyword"] = this.form.keyword
        }

        if (this.form.bedrooms !== 0 || this.form.bedrooms !== "" ){
          queryParams["bedrooms"] = this.form.bedrooms
        }

        if (this.form.bathrooms !== 0 || this.form.bathrooms !== null ){
          queryParams["bathrooms"] = this.form.bathrooms
        }

        if (this.form.garages !== 0 || this.form.garages !== null ){
          queryParams["garages"] = this.form.garages
        }

        if (this.form.storeys !== 0 || this.form.storeys !== null ){
          queryParams["storeys"] = this.form.storeys
        }

        if (this.form.priceRange.length > 0){
          queryParams["price_min"] = this.form.priceRange[0]
          queryParams["price_max"] = this.form.priceRange[1]
        }

        return queryParams;
      }

    }

  }

</script>

