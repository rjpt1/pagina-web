Vue.component('saludo',{
  template:`//esta es TILDE invertida
  <div>
  <h1 >TITULO DESDE COMPONENTE {{titulo}}</h1>
  <h3> Este es el mensaje {{varnombre}} </h3>
  </div>
  ` ,//esta es TILDE invertida
  props:['varnombre'],
  data(){
    return{
      titulo:'COMPONENTE SALUDO'
    }
  }
})

var app = new Vue({
  el: '#crud',
  mounted(){
    //alert('Hola mundo desde mounted')
    axios.get('https://jsonplaceholder.typicode.com/posts').then((respuesta) => {
      console.log(respuesta.data)
      this.posts=respuesta.data
    })

    axios.get('https://jsonplaceholder.typicode.com/users').then((respuesta2) => {
      console.log(respuesta2.data)
      this.userpost=respuesta2.data
    })
  },
  data: {
    posts:[],
    userpost:null,
    eserie:null,
    epelicula:null,
    nuevapelicula:{id:null,nombre:'',estreno:null,sinompsis:''},
    //

    bpost:'',
    bpelicula:'',
    buscarPelicula:'',
	  buscarPorCategoria:'1',
    numero:10,
    pagina:1,

    mensaje: '¡Hola desde Vue!',
    nota:'',
    nuevoNombrePelicula:'',
    nuevoEstrenoPelicula:'',
    nuevoSinopsisPelicula:'',
    nuevaserie:'',
    mostrar:true,
    crear:true,
    idpeli:'0',
    series:['Dragon Ball','Walking Dead','Dexter','Law & Order'],
    peliculas:[
      {id:'101', nombre:'Whiplash', estreno:'2014', sinopsis:'A promising young drummer enrolls at a cut-throat music conservatory where his dreams of greatness are mentored by an instructor who will stop at nothing to realize a student\'s potential.'},
      {id:'102',nombre:'The Matrix', estreno:'1999', sinopsis:'A computer hacker learns from mysterious rebels about the true nature of his reality and his role in the war against its controllers.'},
      {id:'103',nombre:'The Fifth Element', estreno:'1997', sinopsis:'In the colorful future, a cab driver unwittingly becomes the central figure in the search for a legendary cosmic weapon to keep Evil and Mr. Zorg at bay. '}
    ]
  },
  methods: {
    Saludar: function () {
      alert("Hola desde función")
    },

    CrearSerie: function(serie){
      if (serie.trim()){
        //alert('Se agregara "'+this.nuevaserie+'" al listado de series')
        this.series.push(this.nuevaserie)
        this.nuevaserie = ''
      }
      else{
        alert('Error, no se permite dejar en blanco el nombre de la serie.')
      }
    },

    EliminarSerie: function(indice){
      if(confirm('¿Desea eliminar la serie?')){
        this.series.splice(indice,1)
      }
    },

    CrearPelicula: function(nombre, estreno, sinopsis){
      if (nombre.trim() && estreno.trim() && sinopsis.trim()){
        if(estreno >= 1900&&estreno<=2018){
          //alert('Se agregara "'+this.nuevaserie+'" al listado de peliculas')
          this.peliculas.push({nombre:nombre, estreno:estreno, sinopsis:sinopsis})
          this.nuevoNombrePelicula=''
          this.nuevoSinopsisPelicula=''
          this.nuevoEstrenoPelicula=''
        }
        else{
          alert('El año no es valido.')
        }
      }
      else{
        alert('Error, no se permite dejar en blanco el ninguno de los campos de la pelicula.')
      }
    },

    EliminarPelicula: function(indice){
      if(confirm('¿Desea eliminar la pelicula?')){
        this.peliculas.splice(indice,1)
      }
    },

    FormEditar: function(idpelicula){
      this.crear=false
      this.idpeli=idpelicula
    },

    EditarPelicula: function(nombre, estreno, sinopsis, id){
      if (nombre.trim() && estreno.trim() && sinopsis.trim()&&estreno >= 1900&&estreno<=2018&&confirm('¿Desea actualizar la pelicula?')){
        this.peliculas.push({nombre:nombre, estreno:estreno, sinopsis:sinopsis})
        this.crear=true
        this.peliculas.splice(id,1)
      }
      else{
        alert('Error, no se permite dejar en blanco ninguno de los campos de la pelicula o un año incongruente.')
      }
    },

    CrearSerie2: function(){
        this.series.push(this.nuevaserie)
        this.nuevaserie = ''
    },

    eliminarSerie(index){
      //delete this.series[index]
      this.series.splice(index,1)
    },

    crearPelicula(){
      this.peliculas.push(this.nuevapelicula)
      this.nuevapelicula={id:null,nombre:'',estreno:null,sinompsis:''}
    },

    eliminarPelicula(index){
      //delete this.series[index]
      this.peliculas.splice(index,1)
    },
  },
  computed:{
    ordenarserie(){
      return this.series.sort()
    },

    camposLlenosPeli(){
      return this.nuevoNombrePelicula && this.nuevoEstrenoPelicula && this.nuevoSinopsisPelicula
    },

    //https://rimorsoft.com/filtros-en-vue-js-usando-computed-properties
    filtrarPelicula(){
      return this.peliculas.filter( (peli) => peli.nombre.toLowerCase().includes(this.buscarPelicula.toLowerCase()))
    },

    //clase 27 abril
  	peliculasfiltradas(){
  		return this.peliculas.filter((pelicula)=>{

        if(this.buscarPorCategoria == 1){
           return pelicula.nombre.toUpperCase().includes(this.bpelicula.toUpperCase())
        }

        if(this.buscarPorCategoria == 2){
           return pelicula.estreno.toUpperCase().includes(this.bpelicula.toUpperCase())
        }

        if(this.buscarPorCategoria == 3){
           return pelicula.sinopsis.toUpperCase().includes(this.bpelicula.toUpperCase())
        }

  		})
  	},

    postfiltrados(){
      return this.posts.filter((post)=>{
        return post.title.toUpperCase().includes(this.bpost.toUpperCase())
      })
    },

  }
})
