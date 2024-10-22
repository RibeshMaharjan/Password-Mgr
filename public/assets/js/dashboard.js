// Table Option Toggle
const dropdownCell = document.querySelectorAll(".dashboard-table .option-cell");

function tableOptionToggle(optioncell) {
  const toggleBtn = optioncell.querySelector(".fa-ellipsis");
  const dropdownMenu = optioncell.querySelector(".option-dropdown-menu");
  
  toggleBtn.addEventListener('click', () => {
    
    const menuVisibility = dropdownMenu.getAttribute("data-visible");
    
    if(menuVisibility === "false") {
      const dropdowntoggle = document.querySelectorAll(".dashboard-table .option-cell");
      dropdowntoggle.forEach(toggle => {
        if( Menu = toggle.querySelector(".option-dropdown-menu") ){
          Menu.setAttribute("data-visible", "false");
        }
      });
      dropdownMenu.setAttribute("data-visible", "true");
    } else {
      dropdownMenu.setAttribute("data-visible", "false");
    }
  });
}

dropdownCell.forEach(optioncell => {
  if(optioncell.querySelector(".fa-ellipsis")) {
    tableOptionToggle(optioncell);
  }
});


// Delete the cedential

const optionDropdownMenu = document.querySelectorAll(".dashboard-table .option-dropdown-menu");
const deleteBtn = document.querySelectorAll(".dashboard-table .option-dropdown-menu .delete-btn");

deleteBtn.forEach(btn => {
    btn.addEventListener('click', () => {

        // Accessing the Account Id to delete
        const tableRow = btn.closest(".dashboard-table-row");
        const tableCell = tableRow.querySelector(".dashboard-table-cell");
        const accountId = tableRow.querySelector("#accound-id");
        
        // Grabbing the Input Element
        const oFormObject = document.forms['form-delete'];
        const oformElement = oFormObject.elements["delete-id"];
        
        // Assign the Account Id to Inpit Element
        oformElement.value = accountId.innerHTML
    });
});