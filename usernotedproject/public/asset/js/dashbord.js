async function openContactModal() {
  const { value: contactType } = await Swal.fire({
      title: '📨 Choose Contact Type',
      input: 'select',
      inputOptions: {
          'support': '🛠 Technical Support',
          'sales': '💰 Sales Inquiry',
          'general': '📋 General Inquiry'
      },
      inputPlaceholder: 'Select contact type...',
      showCancelButton: true,
      confirmButtonText: 'Next ➝',
      allowOutsideClick: false,
      backdrop: 'rgba(0,0,0,0.5)',
      preConfirm: (type) => {
          if (!type) Swal.showValidationMessage('⚠️ Please select a contact type');
      }
  });
  if (!contactType) return;
  let dynamicFields = '';
  if (contactType === 'support') {
      dynamicFields = `
          <select id="swal-issue-type" class="swal-select">
              <option value="">🔧 Select Issue Type</option>
              <option value="bug">🐛 Bug Report</option>
              <option value="feature">💡 Feature Request</option>
              <option value="other">❓ Other</option>
          </select>
      `;
  } else if (contactType === 'sales') {
      dynamicFields = `
          <input type="number" id="swal-budget" class="swal-input" 
                 placeholder="💵 Estimated Budget (USD)" min="0">
      `;
  }
  const { value: formValues } = await Swal.fire({
      title: '📝 Compose Message',
      html: `
          <div class="form-group">
              <input type="email" id="swal-email" class="swal-input" 
                     placeholder="📧 Your Email" required>
          </div>
          <div class="form-group">
              <input type="text" id="swal-subject" class="swal-input" 
                     placeholder="🖋 Subject">
          </div>
          ${dynamicFields}
          <div class="form-group">
              <textarea id="swal-message" class="swal-textarea" 
                        placeholder="💬 Your message..."></textarea>
          </div>
          <div style="display: flex; align-items: center;">
              <input type="checkbox" id="swal-urgent" class="custom-checkbox" style="width: 16px; height: 16px;">
              <label for="swal-urgent" class="checkbox-label" style="margin-left: 8px;">❗ Mark as urgent</label>
          </div>
      `,
      showCancelButton: true,
      confirmButtonText: 'Send ➝',
      focusConfirm: false,
      preConfirm: () => {
          const getValue = id => document.getElementById(id)?.value.trim();
          const email = getValue('swal-email');
          const subject = getValue('swal-subject');
          const message = getValue('swal-message');
          const urgent = document.getElementById('swal-urgent').checked;
          const extraData = {
              issueType: getValue('swal-issue-type'),
              budget: getValue('swal-budget')
          };

          if (!email || !message) {
              Swal.showValidationMessage('⚠️ Email and Message are required!');
              return false;
          }
          if (!/^\w+([.-]?\w+)*@\w+([.-]?\w+)*(\.\w{2,3})+$/.test(email)) {
              Swal.showValidationMessage('❌ Please enter a valid email!');
              return false;
          }

          return { email, subject, message, urgent, ...extraData };
      }
  });

  if (!formValues) return;
  const { isConfirmed } = await Swal.fire({
      title: '✅Confirm Send',
      html: `
          <div style="text-align: left;">
              <p><b>📧 Email:</b> ${formValues.email}</p>
              <p><b>📋 Type:</b> ${contactType.toUpperCase()}</p>
              <p><b>🖊 Subject:</b> ${formValues.subject || 'No subject'}</p>
              ${formValues.urgent ? '<p style="color:red;">⚠️ URGENT MESSAGE</p>' : ''}
              <hr>
              <p>${formValues.message}</p>
          </div>
      `,
      icon: 'info',
      showCancelButton: true,
      confirmButtonText: '📤 Confirm Send'
  });

  if (!isConfirmed) return;

  Swal.fire({
      title: '📡 Sending Message...',
      html: `
          <div class="sending-animation">
              <div class="loader"></div>
              <p>We're delivering your message...</p>
          </div>
      `,
      showConfirmButton: false,
      allowOutsideClick: false
  });


  setTimeout(() => {
      Swal.close(); 


      Swal.fire({
          title: '🚀 Message Sent!',
          text: 'Your message has been successfully delivered.',
          icon: 'success',
          timer: 1500,
          showConfirmButton: false
      });
  }, 2000);
}



function toggleSettings() {
    var settings = document.getElementById("settingsPanel");


    if (!settings) {
        console.error("⚠️ settingsPanel not found!");
        return;
    }

    settings.classList.toggle("active");
}


