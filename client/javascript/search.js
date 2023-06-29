
const input_search = document.querySelector('.search_input');
const div_date = document.querySelector('.search_date');


input_search.addEventListener('focus', () => {
  
  div_date.classList.remove('hidden');
 
});
