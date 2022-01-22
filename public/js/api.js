const clientRequest = (url, method, data, callback) => {
    axios({url, method, data})
    .then(res => callback(true, res))
    .catch(err => callback(false, err.response))
}

export default clientRequest;
