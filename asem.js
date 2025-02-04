function get_summaries(subject_id, section_id, div = document.getElementById('summaries')){
   const api = 'php/get_summaries.php'
   fetch(api, {
       'method': 'POST',
       'body':JSON.stringify({
           'subject_id': subject_id ,
           'section_id': section_id
       })
   })
   .then(res => res.json())
   .then(data => {
      if(data['succes']){
         div.innerHTML = ''
         for(item in data['data']){
            item = data['data'][item]
            let componant = `
            <div class="box-info" id="summaries" onclick="location = 'summary_info.php?id=${item['id']}'">
               <h3>${item['name']}</h3>
               <p>${item['info']}</p>
               <span class="auther">${item['auther_name']}</span> 
            </div>`
            div.innerHTML += componant
            Array.from(document.getElementById('sections').children).forEach(element => {
               element.firstChild.classList.remove('active')
            });
            document.getElementById(section_id).classList.add('active')
            // document.getElementById(section_id).nextSibling.forEach(element => {
            //    element.classList.remove('active')
            // });
         }
      }
   })

}

function NotifyTemplete(title, content, type = 'notify'){
   const tools = {
      'warrning':{
         'icon':'fa-circle-info',
         'color':'#f00',
      },
      'notify':{
         'icon':'fa-bell',
         'color':'#2a2',
      }
   }
   const err = 
   `<div id="notify" class="notify" style="background-color: ${tools[type]['color'] + '4'};">
      <i class="fas ${tools[type]['icon']}" style="color: ${tools[type]['color']};"></i>
      <p><b>${title} : </b>${content} </p>
      <i class="fas fa-xmark" onclick="document.getElementsByClassName('notify')[0].outerHTML = ''"></i>
   </div>`;
   return err;
}