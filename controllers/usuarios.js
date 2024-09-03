fetch('http://localhost/Sicosis_Store/api_rest/usuarios.php')
    .then(Response => response.json())
    .then(data =>{
        console.log(data);
    })
    .catch(error=>{
        console.error('Error al consumir api',error);
    })