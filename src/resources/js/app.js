import './bootstrap';

window.addEventListener('alert',(e)=>{
    console.log(e.detail);
    Swal.fire({
        title: e.detail.title,
        text: e.detail.text,
        icon: e.detail.type
      });
})