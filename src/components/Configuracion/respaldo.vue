<template>
  <div>
      <h1>Pruebas de excel</h1>
      <input id="archivoExcel" type="file" @change = "subirExcel()" />
      <b-table
          :headers="cabecera"
          :items="items"
      >
      </b-table>
  </div>
  </template>
  
<script>
  import readXlsFile from "read-excel-file"
  export default {
      data: () => ({
          items:[],

          cabecera:[
              {text:'id',value:'0'},
              {text:'tipo',value:'1'},
              {text:'codigo',value:'2'},
              {text:'nombre',value:'3'},
              {text:'descripcion',value:'4'},
              {text:'categoria',value:'5'},
              {text:'precio',value:'6'},
          ]

      }),
      methods: {
        subirExcel(){
          const input = document.getElementById("archivoExcel");
              readXlsFile(input.files[0]).then((rows) =>{
                  this.items = rows;
                  
              })
          }
      }
  }
</script>
  
<style>
</style>