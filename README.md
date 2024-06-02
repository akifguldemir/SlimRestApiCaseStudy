Import users command : php import/import_users.php<br>
Import posts command : php import/import_posts.php

Not: User import yapısı bozulmaması için user role ataması yapmıyorum. Eğer "Sincere@april.biz" email adresi ile login olunursa admin kabul edilecek.

Not 2: User import yapısı bozulmaması için password alanı oluşturmuyorum. Admin sadece mail ile giriş yapabilecek. Normalde şifreli login olunmalı ve şifreler hash'lenmiş olarak db de saklanmalı.