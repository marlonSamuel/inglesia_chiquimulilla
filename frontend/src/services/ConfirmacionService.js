class ConfirmacionService{
    axios
    baseUrl

    constructor(axios,baseUrl){
        this.axios = axios
        this.baseUrl = `${baseUrl}confirmaciones`
    }

    getAll(){
        let self = this
        return self.axios.get(`${self.baseUrl}`)
    }

    get(id){
        let self = this
        return self.axios.get(`${self.baseUrl}/${id}`)
    }

    create(data){
        let self = this
        return self.axios.post(`${self.baseUrl}`,data)
    }

    update(data){
        let self = this
        return self.axios.put(`${self.baseUrl}/${data.id}`,data)
    }

    destroy(data){
        let self = this
        return self.axios.delete(`${self.baseUrl}/${data.id}`)
    }

    print(id) {
        let self = this
        return self.axios.get(`${self.baseUrl}_pdf/${id}`, { responseType: 'blob' });
    }

    printAll(from,to) {
        let self = this
        return self.axios.get(`${self.baseUrl}_print/${from}/${to}`, { responseType: 'blob' });
    }
}

export default ConfirmacionService