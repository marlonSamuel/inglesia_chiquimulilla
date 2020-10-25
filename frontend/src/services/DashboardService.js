class DashboardService{
    axios
    baseUrl

    constructor(axios,baseUrl){
        this.axios = axios
        this.baseUrl = `${baseUrl}dashboard`
    }

    getAll(){
        let self = this
        return self.axios.get(`${self.baseUrl}_index`)
    }

}

export default DashboardService