
document.querySelectorAll('.otp-input').forEach((input, idx, inputs) => {
    input.addEventListener('input', () => {
        if (input.value.length === 1 && idx < inputs.length - 1) {
            inputs[idx + 1].focus();
        }
    });

    input.addEventListener('keydown', (e) => {
        if (e.key === 'Backspace' && input.value === '' && idx > 0) {
            inputs[idx - 1].focus();
        }
    });
});


async function sendWhatsAppOTP(phone) {
    const apiKey = '$2y$10$R7v8gbiDT/6qzE2k/oRxsuqtGUE5xSeNiGtKOmZeSJ1PuWdxCX0PW';

    // 👈 توليد OTP محليًا
    const generatedOtp = String(Math.floor(100000 + Math.random() * 900000)); // 6 digits

    const payload = {
        phone: phone,           // رقم الجوال بصيغة دولية
        method: 'whatsapp',     // قناة الإرسال
        template_id: 1,         // رقم القالب (افتراضي)
        otp_format: 'numeric',  // شكل OTP
        number_of_digits: 6,    // عدد الأرقام
        is_fallback_on: false,  // بدون fallback
        otp: generatedOtp       // 👈 هنا نرسل OTP الذي ولّدناه
    };

    try {
        const response = await fetch('https://api.authentica.sa/api/v1/send-otp', {
            method: 'POST',
            headers: {
                'X-Authorization': apiKey,
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(payload)
        });

        const data = await response.json();

        if (!response.ok) {
            console.error('❌ Error response:', data);
            return null;
        }

        console.log('✅ OTP sent via Authentica');
        return generatedOtp; // 👈 نعيد OTP الذي أنشأناه

    } catch (error) {
        console.error('❌ Request failed:', error);
        return null;
    }
}
function otpCheck() {
            const otpInputs = document.querySelectorAll('.otp-input');
            let enteredOtp = '';
            otpInputs.forEach(input => {
                enteredOtp = input.value + enteredOtp;
            });

            if (enteredOtp === global_otp) {
                // OTP صحيح، استدعاء التسجيل
                return true;
            } else {
                return false;
            }
        }