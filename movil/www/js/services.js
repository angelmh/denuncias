angular.module('starter.services', [])

.factory('userService', function($http) {

        var user = ''; var pw = '';var id_user = '';var name_user='';var dpto='';

        return {
            user:{
                getProperty: function () {
                return user;
                },
                setProperty: function(value) {
                    user = value;
                }
            },
            password:
            {
                getProperty: function () {
                return pw;
                },
                setProperty: function(value) {
                    pw = value;
                }  
            },
            id:
            {
                getProperty: function () {
                return id_user;
                },
                setProperty: function(value) {
                    id_user = value;
                }  
            },
            name:
            {
                getProperty: function () {
                return name_user;
                },
                setProperty: function(value) {
                    name_user = value;
                }  
            },
            departamento:
            {
                getProperty: function () {
                return dpto;
                },
                setProperty: function(value) {
                    dpto = value;
                }  
            }
    }
})

.factory('LoginService', function($http) {

    return {
        LoginTrabajador: function(user, pw){
            var params= { 'user': user,
                          'password': pw
                        };
            var req = {
              method: 'POST',
              url: "http://www.denunciaciudadana.esy.es/index.php/auth/usertrabajador",
              data: params
            };

            return $http(req)
        }
    }
})


.factory('SrcImagenService', function($http) {
    //http://www.denunciaciudadana.esy.es/data/img/Bache-traga-camioneta.jpg
     var src = ''; 

    return {
                imagen:{
                    getProperty: function () {
                    return src;
                    },
                    setProperty: function(value) {
                    src = value;
                    }
                }
            }
})

.factory('DireccionService', function($http) {
    
    var country = ''; var route = ''; var cp = ''; var locality = ''; var numero = ''; var colonia= '';
    var latitud = ''; var longitud = ''; var direccion = '';

    return {
                country: {
                        getProperty: function () {
                        return country;
                        },
                        setProperty: function(value) {
                        country = value;
                        }
                },
                route: {
                        getProperty: function () {
                        return route;
                        },
                        setProperty: function(value) {
                        route = value;
                        }
                },
                postal_code: {
                        getProperty: function () {
                        return cp;
                        },
                        setProperty: function(value) {
                        cp = value;
                        }
                },
                locality: {
                        getProperty: function () {
                        return locality;
                        },
                        setProperty: function(value) {
                        locality = value;
                        }
                },
                numero: {
                        getProperty: function () {
                        return numero;
                        },
                        setProperty: function(value) {
                        numero = value;
                        }
                },
                colonia: {
                        getProperty: function () {
                        return colonia;
                        },
                        setProperty: function(value) {
                        colonia = value;
                        }
                },
                descripcion_direccion_by_google: {
                        getProperty: function () {
                        return direccion;
                        },
                        setProperty: function(value) {
                        direccion = value;
                        }
                },
                latitud: {
                        getProperty: function () {
                        return latitud;
                        },
                        setProperty: function(value) {
                        latitud = value;
                        }
                },
                longitud: {
                        getProperty: function () {
                        return longitud;
                        },
                        setProperty: function(value) {
                        longitud = value;
                        }
                }
            }
})

.factory('ImagenService', function() {

     var id = ''; 

    return {
                imagen:{
                    getProperty: function () {
                    return id;
                    },
                    setProperty: function(value) {
                    id = value;
                    }
                }
            }
})

.factory('EstatusService', function() {

     var cambio = false; 

    return {
                estatus:{
                    getProperty: function () {
                    return cambio;
                    },
                    setProperty: function(value) {
                    cambio = value;
                    }
                }
            }
})