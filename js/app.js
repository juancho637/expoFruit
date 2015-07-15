//inicialización de la app expoFruit
var expoF = angular.module('expoFruit', ['lumx']);

//inicialización de variables a usar
var serv = {}; //servicios para cargar funciones dentro de los controlles
var url; //url que cambia para realizar el cambio de $scope.ur

serv.loader = function(n){
    if(n == 1)
	$('#loaderQ').css('display', 'inline-table');
    else
	$('#loaderQ').css('display', 'none');
};

//inicialización de los servicios: se pueden usar en cualquier parte del codigo js en conjunto a los controladores
expoF.service('seccion', function(){
    this.ini = function($scope, $http){
	var request = $http({
            method: 'POST',
            url: $scope.url,
            data: {
		type: 'loginConsult'
            }
	});
	request.success(
            function(response){
                //alert(response);
                //serv.ur([response[0][0],response[0][4]]);
                serv.ur(response);
                //serv.res = response[0][1];
                serv.cambio(1);
            }
	);
    };
});

//configuración de los controladores: solo se pueden usar una vez no se pueden invocar en otros controladores
expoF.controller("iniController", function ($scope) {
    url = (location.href).replace(/^[a-zA-Z-0-9:\/]*[#\/]*/, '');
    $scope.url = 'php/funciones.php';//se inicializa la url del servicio
    //alert(url);
    $scope.cambio = url;
    serv.cambio = function(n){
        //alert(n);
        if(n == 1){
            $scope.cambio = url;
        }
        serv.loader(0);
    };
});

expoF.controller("inicio", function () {
     $('.bxslider').bxSlider({
              auto: true,
              // autoControls: true
              controls: null
             });
    serv.loader(0);
});

expoF.controller("productos", function () {
    serv.loader(0);
});

expoF.controller("proctosAdmin", function ($scope, $http) {
    serv.loader(1);
    var request = $http({
        method: 'POST',
        url: $scope.url,
        data: {
            type: 'productosAdminConsul'
        }
    });
    request.success(function(response){
        $scope.datosProductos = response;
        serv.loader(0);
    });
    $scope.eliminarProducto = function (id){
        console.log(id);
    };
    $scope.editarProducto = function (id){
        console.log(id);
    };
    
    $scope.filee1 = function (){
        var tmppath = URL.createObjectURL(event.target.files[0]);
        $("#img1").attr("src", tmppath);
        $("#img1").css("display","inline");
    };
    $scope.filee2 = function (){
        var tmppath = URL.createObjectURL(event.target.files[0]);
        $("#img2").attr("src", tmppath);
        $("#img2").css("display","inline");
    };
    $scope.filee3 = function (){
        var tmppath = URL.createObjectURL(event.target.files[0]);
        $("#img3").attr("src", tmppath);
        $("#img3").css("display","inline");
    };
});

expoF.controller("empleados", function () {
    serv.loader(0);
});

expoF.controller("correo", function () {
    serv.loader(0);
});
expoF.controller("exportaciones", function () {
    serv.loader(0);
});
expoF.controller("calendario", function () {
    serv.loader(0);
});

expoF.controller("perfil", function ($scope, $http, seccion, LxNotificationService, LxDialogService) {
    var request = $http({
        method: 'POST',
        url: $scope.url,
        data: {
            type: 'consultaPerfil'
        }
    });
    request.success(function (response){
        //console.log(response);        
        $scope.paiss = response;
        $scope.ciudadd = response;
        $scope.nickName = response[0][0];
        $scope.contrasena = response[0][1];
        $scope.nombre = response[0][2];
        $scope.apellido = response[0][3];
        $scope.mail = response[0][4];
        $scope.tel = response[0][5];
        $scope.cell = response[0][6];
        $scope.direccion = response[0][7];
        $scope.ciudad = response[0][9];
        serv.loader(0);
    });
    
    $scope.selecP = function (par){
        //console.log(par);
        serv.loader(1);
        var request = $http({
            method: 'POST',
            url: $scope.url,
            data: {
                type: 'consultaCiudades',
                valor: par
            }
        });
        request.success(function (response){
            //console.log(response.ciudades);
            $scope.ciudadd = response;
            serv.loader(0);
        });
    };
    
    $scope.emailValidation = function(email){
        return /^[0-9a-zA-Z]+([0-9a-zA-Z]*[-._+])*[0-9a-zA-Z]+@[0-9a-zA-Z]+([-.][0-9a-zA-Z]+)*([0-9a-zA-Z]*[.])[a-zA-Z]{2,6}$/.test(email);
    };
    
    $scope.cambiarPassword = function (){
        alert("cambiar contra");
    };
    
    $scope.actualizarDatos = function (){
        var hola = 'Nombre: '+$scope.nombre+"\nApellido: "+$scope.apellido+"\nTelefono: "+$scope.tel+"\nCelular: "+$scope.cell+"\nE-mail: "+$scope.mail+"\nPais: "+$scope.paiss[0].selecP.Country+"\nRegion: "+$scope.ciudadd[0].selecR.Region+"\nCiudad: "+$scope.ciudad+"\nDireccion: "+$scope.direccion;
        LxNotificationService.confirm('Por favor revisa que tus datos esten correctos',hola, { cancel:'Cancelar', ok:'Aceptar' }, function(answer){
            if(answer == true){
                var pais = $scope.paiss[0].selecP.CountryId;
                var region = $scope.ciudadd[0].selecR.RegionId;

                var request = $http({
                    method: 'POST',
                    url: $scope.url,
                    data: {
                        type: 'updatePerfil',
                        nombre: $scope.nombre,
                        apellido: $scope.apellido,
                        telefono: $scope.tel,
                        cell: $scope.cell,
                        mail: $scope.mail,
                        pais: pais,
                        region: region,
                        ciudad: $scope.ciudad,
                        direccion: $scope.direccion
                    }
                });
                request.success(function (response){
                    console.log(response);
                });
            }else{
                console.log("no");
            }
        });
    };
    
    $scope.cerrarCuenta = function (){
        var uno = $("#select").val();
        alert(uno);
    };
});

expoF.controller("clientes", function ($http, $scope, LxDialogService) {
    serv.loader(1);
    var request = $http({
        method: 'POST',
        url: $scope.url,
        data: {
            type: 'clientesAdminConsul'
        }
    });
    request.success(function(response){
        //console.log(response);
        $scope.datosClientes = response;
        serv.loader(0);
    });
    
    $scope.opendDialog = function(dialogId,cliente){
        LxDialogService.open(dialogId);
        $scope.especifco = cliente;
    };
    
    $scope.varMas = function (nick){
        console.log(nick);
    };
});

expoF.controller("nav", function ($scope, $http, seccion, LxNotificationService, LxDialogService) {
    seccion.ini($scope, $http);
    serv.ur = function(n){//se activa al iniciar la pagina web para ver si algun usuario se encuantra logeado
        if(n == 'null'){
            $scope.valor = "iniciar sesión";
            $scope.mIni = 0;
        }else{
            var nombre = n[0][4];
            var spli = nombre.split(" ");
            $scope.valor = spli[0];
            $scope.rl = n[0][3];
            $scope.cr = n[0][16];
            $scope.mIni = 1;
        }
    };
    
    $scope.urlChange = function(ur){
        if(ur != url){
            //console.log("no");
            url = ur;
            serv.cambio(1);
            serv.loader(1);
        }else{
            //console.log("si");
            serv.loader(0);
        }
    };
    
    $scope.EnviarRegis = function (){
        var un = undefined;
        if($scope.nickName == un || $scope.contrasena == un || $scope.contrasena2 == un || $scope.nombre == un || $scope.apellido == un || $scope.mail == un || $scope.telefono == un || $scope.cell == un || $("#select1").val() == un || $("#select2").val() == un || $scope.ciudad == un || $scope.direccion == un){
            //alert('llena todos los campos correspondientes por favor');
        }else{
            if($scope.nickName == '' || $scope.contrasena == '' || $scope.contrasena2 == '' || $scope.nombre == '' || $scope.apellido == '' || $scope.mail == '' || $scope.telefono == '' || $scope.cell == '' || $("#select1").val() == '' || $("#select2").val() == '' || $scope.ciudad == '' || $scope.direccion == ''){
                //alert('llena todos los campos correspondientes por favor');
            }else{
                var request = $http({
                    method: 'POST',
                    url: $scope.url,
                    data: {
                        type: 'consultaUserMail',
                        nickName: $scope.nickName,
                        mail: $scope.mail
                    }
                });
                request.success(function (response){
                    if(response[0] >= 1){
                        alert('este nombre de usuario ya existe');
                    }else{
                        if(response[1] >= 1){
                            alert('este E-mail ya existe');
                        }else{
                            if($scope.contrasena != $scope.contrasena2){
                                alert('Las contraseñas son diferentes');                               
                            }else{
                                var request = $http({
                                    method: 'POST',
                                    url: $scope.url,
                                    data: {
                                        type: 'nuevo',
                                        nick: $scope.nickName,
                                        pass: $scope.contrasena,
                                        nombre: $scope.nombre,
                                        apellido: $scope.apellido,
                                        mail: $scope.mail,
                                        tel: $scope.telefono,
                                        cell: $scope.cell,
                                        pais: $scope.pais.Country.CountryId,
                                        region: $scope.ciudadd.City.RegionId,
                                        ciudad: $scope.ciudad,
                                        direccion: $scope.direccion
                                    }
                                });
                                request.success(function (response){
                                    LxNotificationService.alert('Registro Insertado', response, 'Ok', function(answer){
                                        console.log(answer);
                                        $('.cerraD').trigger('click');
                                        $scope.nickName = "";
                                        $scope.contrasena = "";
                                        $scope.nombre = "";
                                        $scope.apellido = "";
                                        $scope.mail = "";
                                        $scope.telefono = "";
                                        $scope.cell = "";
                                        $scope.ciudad = "";
                                        $scope.direccion = "";
                                    });
                                });
                            }
                        }
                    }
                });
            }
        }
    };
    
    $scope.emailValidation = function(email){
        return /^[0-9a-zA-Z]+([0-9a-zA-Z]*[-._+])*[0-9a-zA-Z]+@[0-9a-zA-Z]+([-.][0-9a-zA-Z]+)*([0-9a-zA-Z]*[.])[a-zA-Z]{2,6}$/.test(email);
    };
    
    $scope.iniciar = function (){//se activa cuando se le da click al boton iniciar sesión
        if ($scope.user == undefined || $scope.pass == undefined || $scope.user == "" || $scope.pass == ""){
            
        }else{
            serv.loader(1);
            var request = $http({
                method: 'POST',
                url: $scope.url,
                data: {
                    type: 'login',
                    user: $scope.user,
                    pass: $scope.pass
                }
            });
            request.success(
                function(response){
                    if(response == 'null'){
                        serv.loader(0);
                        $scope.valor = "iniciar sesión";
                        $scope.mIni = 0;
                        alert("Usuario o contraseña incorrectas");
                    }else{
                        $('.cerraD').trigger('click');
                        var nombre = response[0][4];
                        var spli = nombre.split(" ");
                        $scope.valor = spli[0];
                        $scope.rl = response[0][3];
                        $scope.mIni = 1;
                        $scope.cr = response[0][16];
                        $scope.user = '';
                        $scope.pass = '';
                        serv.loader(0);
                    }
                }
            );
        }
    };
    // inicio ejemplo
    $scope.opendDialog = function(dialogId){
        var request = $http({
            method: 'POST',
            url: $scope.url,
            data: {
		type: 'consultaPais'
            }
	});
        request.success(function(response){
            $scope.pais = response;
        });
        LxDialogService.open(dialogId);
    };
    
    $scope.selecP = function (id){
        serv.loader(1);
        var request = $http({
            method: 'POST',
            url: $scope.url,
            data: {
                type: 'consultaRegion',
                valor: id.CountryId
            }
        });
        request.success(function (response){
            $scope.ciudadd = response;
            serv.loader(0);
        });
    };
    
    $scope.opendDialog2 = function(dialogId)
    {
        LxDialogService.open(dialogId);
    };
    //fin ejemplo
    
    $scope.closeSesion = function(){// se activa cuando se da click al boton cerrar sesión
        serv.loader(1);
        var request = $http({
            method: 'POST',
            url: $scope.url,
            data: {
                type: 'cerrarSession'
            }
        });
        request.success(function(response){
            $scope.valor = "iniciar sesión";
            $scope.mIni = 0;
            url = '';
            serv.cambio(1);
            serv.loader(0);
        });
    };
});