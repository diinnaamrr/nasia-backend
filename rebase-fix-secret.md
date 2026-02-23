# إزالة Mapbox token من الـ history - نفذ بالترتيب في PowerShell

# 1) نسخ الملف المُصلح خارج الـ repo
Copy-Item public\assets\admin\js\theme.min.js theme.min.js.FIXED

# 2) rebase تفاعلي (استخدم ~1 بدل ^ لأنك على PowerShell)
git rebase -i 9a9e13fa~1

# 3) في المحرر: غيّر "pick" إلى "edit" في السطر اللي فيه 9a9e13fa فقط، احفظ واقفل

# 4) بعد ما الـ rebase يقف، استبدل الملف بالنسخة المُصلحة
Copy-Item theme.min.js.FIXED public\assets\admin\js\theme.min.js -Force

# 5) ضم التعديل في نفس الـ commit وأكمل الـ rebase
git add public/assets/admin/js/theme.min.js
git commit --amend --no-edit
git rebase --continue

# 6) لو فتح محرر لرسالة الـ commit: احفظ واقفل (أو اكتب رسالة ثم احفظ واقفل)

# 7) مسح المؤقت ورفع الفرع
Remove-Item theme.min.js.FIXED -ErrorAction SilentlyContinue
git push origin dev --force-with-lease
