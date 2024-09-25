## Installation

To set up code for local development from a GitHub source, follow these steps:

1. **Clone the Repository**: Run `git clone https://github.com/turahe/backend-test.git` in your terminal.
2. **Navigate to the Directory**: Change to the project directory using `cd backend-test`.
3. **Install Dependencies**: Run `composer install` to install PHP dependencies.
4. **Set Up Environment File**: Copy `.env.example` to `.env` with `cp .env.example .env`.
5. **Generate Application Key**: Use `php artisan key:generate`.
6. **Set Up Database**: Configure your database settings in the `.env` file.
7. **Run Migrations and seed data dummy**: Execute `php artisan migrate:seed` to set up your database schema.
8. **Generate api docs**: Use `php artisan scribe:generate`. Can be access via <http://localhost:8000/docs>
9. **Serve the Application**: run `php artisan serve` to start the local development server <http://localhost:8000>.
10. **View unit test results**: Run the command `php artisan test` or `./vendor/bin/phpunit --testdox` to check the unit test results.

## the design choices I made and the performance tuning techniques I implemented

Using cache to optimize queries in Backed Test is important for improving performance and reducing the load on your database. Here’s why caching can be beneficial in this context:

### 1. **Reduced Database Load**:
- Repeatedly executing the same queries can be costly, especially if the database is large or if multiple authors are accessing the system concurrently.
- By caching query results, you reduce the number of queries sent to the database, thus decreasing the database load and improving its overall performance.

### 2. **Faster Response Times**:
- Retrieving data from the cache is faster than executing a database query, as cached data is stored in memory (e.g., Redis or Memcached), which can be accessed more quickly than querying the database.
- This results in quicker page load times and an improved user experience.

### 3. **Improved Scalability**:
- As your application grows and more authors interact with it, the database can become a bottleneck.
- By using caching, you allow your system to handle more requests without constantly querying the database, making your application more scalable.

### 4. **Handling Expensive Queries**:
- Some queries (e.g., those involving complex joins, aggregations, or calculations) can be expensive in terms of time and resources.
- By caching the results of these expensive queries, you can avoid the performance overhead associated with executing them repeatedly.

### 5. **Reduce External API Calls**:
- If your queries involve fetching data from external APIs, caching can prevent you from making redundant calls to external services, reducing latency and the risk of hitting API rate limits.

### 6. **Cache Expiration**:
- Backed Test provides mechanisms to set expiration times for cache entries, ensuring that the cached data remains fresh and consistent with the database without needing to manually invalidate it.
- You can configure the cache duration based on how often the data changes.

### Example: Using Cache in Backed Test Queries
Backed Test’s `Cache` facade allows you to easily cache the results of your database queries:

```php
use Illuminate\Support\Facades\Cache;

 $authors = Cache::remember('authors', 60, function () {
            return Author::paginate(12);
        });
```

In this example:
- The `remember` method checks if the data for the key `authors` is already in the cache. If not, it executes the query and caches the result for 60 minutes.

By doing this, subsequent requests will pull the data from the cache instead of querying the database, significantly boosting performance.

### Common Caching Stores in Backed Test:
- **File**: Stores cache data in the file system.
- **Database**: Stores cache data in a database table.
- **Redis**: An in-memory key-value store, great for high performance.
- **Memcached**: Another fast, in-memory caching system.

### Conclusion:
Using cache for optimizing queries in Backed Test is an effective way to improve performance, reduce the load on your database, and enhance scalability, especially for expensive or frequently repeated queries.

