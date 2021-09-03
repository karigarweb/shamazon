class Request {
    constructor()
    {
        this.baseUrl = baseUrl;
        let service = axios.create({
            headers: {
                csrf: 'token',
                accept: 'application/json'
            }
        });

        //service.defaults.headers.common['Authorization'] = 'Bearer ' + $('meta[name="user_token"]').attr('content');

        service.interceptors.response.use(this._handleSuccess, this._handleError);
        this.service = service;
    }

    _handleSuccess(response) {
        return response;
    }

    _handleError = (error) => {
        switch (error.response && error.response.status) {
            case 401:
                $('#backErr').html(error.response.error);
                console.log(" toast.error('Unauthorized, check console for details');");
                break;
            case 404:
                console.log(" toast.error('Route not found, check console for details');")
                break;
            case 422:
                let { errors } = error.response.data
                let ul = document.createElement('ul');
                Object.keys(errors).forEach(error => {
                    let li = document.createElement('li');
                    li.innerText = errors[error]
                    ul.append(li)
                });

                $('#backErr').html('');
                $('#backErr').append(ul);
                $('#backErr').removeClass('invisible');
                document.getElementById('backErr').innerHTML = '';
                document.getElementById('backErr').append(ul);
                document.getElementById('backErr').classList.remove("invisible");
            default:
                console.log("toast.error('Server/Unknown error occurred, check console for details');")
                break;
        }

        return Promise.reject(error);
    };

    _redirectTo = (document, path) => {
        document.location = path;
    };

    /**
     * Method to handle api requests.
     * @param {string} type
     * @param {string} path
     * @param {Object} [payload]
     */
    send(type, path, payload, bearerToken) {

        $('#backErr').addClass('invisible');
        //document.getElementById('backErr').classList.add("invisible");
        type = type.toLowerCase();

        if (path.includes('http') || path.includes('https')) {
            if (path.startsWith('/')) path = path.substr(path.indexOf('/') + 1);
        } else {
            path = this.baseUrl + path;
        }

        //Load token from local storage if not available in request
        if (typeof bearerToken === 'undefined') {

            /*let token = document.querySelector('meta[name="user_token"]').getAttribute('content');
            let currentUser = localStorage.getItem('currentUser');
            if (typeof currentUser !== 'undefined' && currentUser) {
                currentUser = JSON.parse(currentUser);
                bearerToken = currentUser.api_token;
            }
            if (typeof token !== 'undefined' && token){
                bearerToken = token;
            }*/
        }

        if (bearerToken) {
            this.service.defaults.headers.Authorization = `Bearer ${bearerToken}`;
        }

        if (type === 'get') {
            return this.service.get(path).then((response) => response.data);
        }

        return this.service
            .request({
                method: type,
                url: path,
                responseType: 'json',
                data: payload
            })
            .then((response) => response.data);
    }
}
