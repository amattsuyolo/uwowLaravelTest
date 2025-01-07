# Q12 Answer

## Setup Instructions (Laravel Sail)

1. **Clone the repository:**
   ```bash
   git clone https://github.com/amattsuyolo/uwowLaravelTest.git
   cd uwowLaravelTest
   ```
2. **Install dependencies using Sail:**
   ```bash
   ./vendor/bin/sail composer install
   ```
3. **Create `.env` file:**
   ```bash
   cp .env.example .env
   ```
4. **Run migrations:**
   ```bash
   ./vendor/bin/sail artisan migrate
   ```
5. **Create a symbolic link for public storage:**
   ```bash
   ./vendor/bin/sail artisan storage:link
   ```
6. **Start the development server:**
   ```bash
   ./vendor/bin/sail up
   ```

## API Endpoints and cURL Tests

### 1. List all posts (GET)
```bash
curl -X GET "http://localhost/api/posts?sort_by=title&order=asc"
```

### 2. Create a new post (POST)
```bash
curl -X POST http://localhost/api/posts \
-H "Content-Type: application/json" \
-d '{
    "title": "New Post with Image",
    "content": "This is the content of the new post",
    "is_active": true
}'
```

### 3. Create a post with an image (POST with Image)
```bash
curl -X POST http://localhost/api/posts \
-F "title=New Post with Image" \
-F "content=This is a post with an image" \
-F "is_active=true" \
-F "image_path=@$HOME/Desktop/test.png"
```

### 4. Update a post (PUT)
```bash
curl -X PUT http://localhost/api/posts/1 \
-H "Content-Type: application/json" \
-d '{
    "title": "Updated Post Title",
    "content": "Updated content",
    "is_active": false
}'
```

### 5. Delete a post (DELETE)
```bash
curl -X DELETE http://localhost/api/posts/1
```

### 6. Search posts (GET with Query Parameter)
```bash
curl -X GET "http://localhost/api/posts/search?query=Post"
```

### 7. Activate a post (PATCH)
```bash
curl -X PATCH http://localhost/api/posts/1/activate
```

### 8. Deactivate a post (PATCH)
```bash
curl -X PATCH http://localhost/api/posts/1/deactivate
```

### 9. Custom Post Ordering (POST)
```bash
curl -X POST http://localhost/api/posts/order \
-H "Content-Type: application/json" \
-d '{
    "posts": [3, 1, 2]
}'
```

##  Project Structure
- **app/Http/Controllers/PostController.php**: Contains all the API logic.
- **database/migrations/**: Migration files for creating posts table.
- **routes/api.php**: API routes definition.

## Testing
You can test the API using the provided `curl` commands or tools like Postman.



# Q17 Answer

INNER JOIN 結果

| UserID | Name             | Age | BrandName | ProductName | Price | Buy Time    |
|--------|-----------------|-----|-----------|-------------|-------|-------------|
| 1      | Prescott Bartlett | 27  | Gap       | Sweater     | 35.99 | 2010/10/02  |
| 3      | Lael Greet        | 30  | Nike      | Shoes       | 125.99| 2013/06/12  |


RIGHT JOIN 結果

| UserID | Name             | Age | BrandName | ProductName | Price | Buy Time    |
|--------|-----------------|-----|-----------|-------------|-------|-------------|
| 1      | Prescott Bartlett | 27  | Gap       | Sweater     | 35.99 | 2010/10/02  |
| 3      | Lael Greet        | 30  | Nike      | Shoes       | 125.99| 2013/06/12  |
| 4      | NULL              | NULL| Adidas    | Shoes       | 105.99| 2013/08/25  |
| 5      | NULL              | NULL| H&M       | Jacket      | 129.99| 2013/05/09  |

# Q18 Answer

## 前端驗證
- **HTML**: 使用 `<input type="number" min="0">` 與 `maxlength`
- **JavaScript**: 表單提交前檢查數值範圍

## Laravel 後端驗證
### Request 驗證器 (推薦)
```php
$request->validate([
    'id' => 'required|integer|min:1',
    'date' => 'required|date',
    'users' => 'required|numeric|min:0|max:9223372036854775807',
    'revenue' => 'required|numeric|min:0|max:999999999999.99',
    'rpm' => 'required|numeric|min:0|max:999999999999.99',
    'landing_page' => 'required|string|max:255'
]);
```

# Q20 Answer
根據圖片過去時間出現三次高峰期,且高峰期後回歸正常

### 故障排查步驟
1. **確認流量**：確認是否有流量暴增、行銷活動或爬蟲攻擊。 
2. **是否有定時任務** : (cron job) 或排程器導致？
3. **查看日誌**：檢查應用程式與伺服器日誌，留意錯誤與重試行為。  
4. **伺服器資源**：檢查 CPU、記憶體使用率與資料庫負載。
5. **分析 SQL 查詢**：檢查慢查詢

---

### 可能原因
- **定時任務或批次處理**：如定期報表生成、備份等
- **爬蟲或惡意攻擊**：行銷活動或爬蟲  
- **重試機制異常**：失敗請求重試導致 
- **查詢效能差**：慢查詢或缺少索引
