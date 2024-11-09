// Dashboard Table


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

// Edit Credentials

const editBtns =  document.querySelectorAll(".edit-btn");

editBtns.forEach(editBtn => {
  
  editBtn.addEventListener('click', ()=> {
    const credentials = editBtn.closest(".credentials");

    var inputs = credentials.querySelectorAll("input");
    console.log(inputs);
    
    const text = [];
    inputs.forEach(input => {
        text.push(input.value);
    });
    const credentialEditModel = document.querySelector("#credential-edit");

    credentialEditModel.querySelector("#id").value = text[0];
    credentialEditModel.querySelector("#username").value = text[1];
    credentialEditModel.querySelector("#password").value = text[2];
    credentialEditModel.querySelector("#notes").value = text[3];
  });
});


// Show Update History Credentials

const updateHistoryBtn = document.querySelectorAll(".update-history");

updateHistoryBtn.forEach(button => {
  const parentElement = button.closest('.dashboard-table-row');
  
  button.addEventListener('click', () => {
    const updateHistoryRow = parentElement.querySelector(".update-history-row");

    // Grabbing the Data Visible Attribute
    visibility = updateHistoryRow.getAttribute("data-visible");
      
    if(visibility === "false") {
      updateHistoryRow.setAttribute("data-visible", "true");
    }
    else {
      updateHistoryRow.setAttribute("data-visible", "false");
    }
  });
});

// Delete the credential
const deleteBtns =  document.querySelectorAll(".delete-btn");

deleteBtns.forEach(deleteBtn => {
  
  deleteBtn.addEventListener('click', ()=> {
    const credentials = deleteBtn.closest(".credentials");

    const accountId = credentials.querySelector("#account_id");
      
    // Grabbing the Input Element
    const oFormObject = document.forms['form-delete'];
    const oformElement = oFormObject.elements["delete-id"];
    
    // Assign the Account Id to Inpit Element
    oformElement.value = accountId.value;
    console.log(accountId.value);
    
  });
});



// const copyBtns = document.querySelectorAll(".copy-btn");

// copyBtns.forEach(copyBtn => {
//   copyBtn.addEventListener('click', function() {
//     const inputContainer = copyBtn.closest(".input-container");
//     const inputField = inputContainer.querySelector("input");
//     console.log(inputField);
//     copyText = inputField.value;
//     navigator.clipboard.writeText(copyText);    
//   });
// })