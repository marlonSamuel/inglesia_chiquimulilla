<script>
import { Bar } from 'vue-chartjs'
import { Pie } from 'vue-chartjs'

export default {
    extends: Pie,
    data(){
      return {
        data: null,
        dataset: {
          label: 'Bautizos, Confirmaciones y Matrimonios',
          backgroundColor: '#f39c12',
          borderWidth: 1,
          data: []
        },

        chartData: {
          labels: ['Bautizos','Confirmaciones','Matrimonios'], 
          datasets: []
        },
        options: {}
      }
    },

    created(){
      let self = this
      self.options = {
        responsive: true,
        maintainAspectRatio: false,
        title: {
          display: true,
          text: 'Resumen de actividades'
        },
        legend: {
            position: 'bottom'
        }
     }

     events.$on('resumen_actividades',self.onEventPagos)
    },

    beforeDestroy(){
        let self = this
        events.$off('resumen_actividades',self.onEventPagos)
    },

    methods: {
      onEventPagos(data){
          let self = this
          self.data = data
          console.log(data)
          self.loadData(data)
      },

      loadData(data) {
          let self = this
          self.dataset.data.push(data[0])
          self.dataset.data.push(data[1])
          self.dataset.data.push(data[2])
          self.dataset.backgroundColor = ['gray', 'blue', 'green']

          console.log(self.dataset)

          self.chartData.datasets.push(self.dataset)
          self.renderChart(self.chartData, self.options)
      }
    },

    mounted () {
      let self = this
      //this.renderChart(self.chartData, self.options)
  
    }
  }
</script>