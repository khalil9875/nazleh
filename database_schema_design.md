# Database Schema Design

## Categories Table

| Column Name | Data Type | Constraints           | Description                       |
|-------------|-----------|-----------------------|-----------------------------------|
| `id`        | `BIGINT`  | `PRIMARY KEY`, `AUTO_INCREMENT` | Unique identifier for the category|
| `name`      | `VARCHAR` | `UNIQUE`, `NOT NULL`  | Name of the category              |
| `slug`      | `VARCHAR` | `UNIQUE`, `NOT NULL`  | URL-friendly slug for the category|
| `description`| `TEXT`    | `NULLABLE`            | Description of the category       |
| `parent_id` | `BIGINT`  | `NULLABLE`, `FOREIGN KEY (categories.id)` | For nested categories             |
| `created_at`| `TIMESTAMP`| `NULLABLE`            | Timestamp of creation             |
| `updated_at`| `TIMESTAMP`| `NULLABLE`            | Timestamp of last update          |

## Products Table

| Column Name | Data Type | Constraints           | Description                       |
|-------------|-----------|-----------------------|-----------------------------------|
| `id`        | `BIGINT`  | `PRIMARY KEY`, `AUTO_INCREMENT` | Unique identifier for the product |
| `category_id`| `BIGINT`  | `NOT NULL`, `FOREIGN KEY (categories.id)` | Category the product belongs to   |
| `name`      | `VARCHAR` | `UNIQUE`, `NOT NULL`  | Name of the product               |
| `slug`      | `VARCHAR` | `UNIQUE`, `NOT NULL`  | URL-friendly slug for the product |
| `description`| `TEXT`    | `NULLABLE`            | Description of the product        |
| `price`     | `DECIMAL(10, 2)`| `NOT NULL`          | Price of the product              |
| `stock`     | `INTEGER` | `NOT NULL`, `DEFAULT 0` | Current stock quantity            |
| `image`     | `VARCHAR` | `NULLABLE`            | Path to the product image         |
| `created_at`| `TIMESTAMP`| `NULLABLE`            | Timestamp of creation             |
| `updated_at`| `TIMESTAMP`| `NULLABLE`            | Timestamp of last update          |

## Orders Table

| Column Name | Data Type | Constraints           | Description                       |
|-------------|-----------|-----------------------|-----------------------------------|
| `id`        | `BIGINT`  | `PRIMARY KEY`, `AUTO_INCREMENT` | Unique identifier for the order   |
| `user_id`   | `BIGINT`  | `NOT NULL`, `FOREIGN KEY (users.id)` | User who placed the order         |
| `total_amount`| `DECIMAL(10, 2)`| `NOT NULL`          | Total amount of the order         |
| `status`    | `VARCHAR` | `NOT NULL`, `DEFAULT 'pending'` | Status of the order (pending, completed, cancelled) |
| `created_at`| `TIMESTAMP`| `NULLABLE`            | Timestamp of creation             |
| `updated_at`| `TIMESTAMP`| `NULLABLE`            | Timestamp of last update          |

## Order_Items Table

| Column Name | Data Type | Constraints           | Description                       |
|-------------|-----------|-----------------------|-----------------------------------|
| `id`        | `BIGINT`  | `PRIMARY KEY`, `AUTO_INCREMENT` | Unique identifier for the order item |
| `order_id`  | `BIGINT`  | `NOT NULL`, `FOREIGN KEY (orders.id)` | Order the item belongs to         |
| `product_id`| `BIGINT`  | `NOT NULL`, `FOREIGN KEY (products.id)` | Product in the order              |
| `quantity`  | `INTEGER` | `NOT NULL`            | Quantity of the product           |
| `price`     | `DECIMAL(10, 2)`| `NOT NULL`          | Price of the product at the time of order |
| `created_at`| `TIMESTAMP`| `NULLABLE`            | Timestamp of creation             |
| `updated_at`| `TIMESTAMP`| `NULLABLE`            | Timestamp of last update          |

