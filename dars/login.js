const form = document.getElementById('auth-form');
const toggleLink = document.getElementById('toggle-link');
const toggleText = document.getElementById('toggle-text');
const formTitle = document.getElementById('form-title');
const emailInput = document.getElementById('email');
const errorMsg = document.getElementById('error-msg');

let isSignup = false;

toggleLink.addEventListener('click', () => {
  isSignup = !isSignup;
  formTitle.textContent = isSignup ? 'ثبت‌نام' : 'ورود';
  toggleText.textContent = isSignup ? 'حساب داری؟' : 'حساب نداری؟';
  toggleLink.textContent = isSignup ? 'وارد شو' : 'ثبت‌نام کن';
  emailInput.style.display = isSignup ? 'block' : 'none';
  errorMsg.textContent = '';
});

form.addEventListener('submit', (e) => {
  e.preventDefault();
  const username = form.username.value.trim();
  const password = form.password.value.trim();
  const email = form.email.value.trim();

  if (username.length < 4) {
    return showError('نام کاربری باید حداقل ۴ حرف باشد');
  }

  if (password.length < 6) {
    return showError('رمز عبور باید حداقل ۶ حرف باشد');
  }

  if (isSignup && !validateEmail(email)) {
    return showError('ایمیل وارد شده معتبر نیست');
  }

  showError('');
  alert(isSignup ? 'ثبت‌نام با موفقیت انجام شد!' : 'ورود با موفقیت انجام شد!');
  form.reset();
});

function showError(message) {
  errorMsg.textContent = message;
}

function validateEmail(email) {
  const pattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  return pattern.test(email);
}
