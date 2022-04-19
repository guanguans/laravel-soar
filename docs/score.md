
## SQL

```php
// 创建表
DB::select(<<<SQL
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
SQL
);
// 插入数据
User::query()->insert([
    'name'              => 'soar',
    'email'             => 'soar@soar.com',
    'email_verified_at' => now(),
    'password'          => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
    'remember_token'    => Str::random(10),
]);
// 更新数据
User::query()->update([
    'name'     => 'name',
    'password' => 'password',
]);
// 查询数据
User::query()->where('name', 'soar')->groupBy('name')->having('created_at', '>', now())->get();
// 删除数据
User::query()->where('name', 'soar')->delete();
```