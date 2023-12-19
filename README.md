# API FOR GAMEDOC VP ALP KEL.8

## Code of conduct

### Branch and commit convention
- [Branch name  and Commit message](https://dev.to/varbsan/a-simplified-convention-for-naming-branches-and-commits-in-git-il4)
  
- [Branch rules](https://medium.com/android-news/gitflow-with-github-c675aa4f606a) 
  

### Design & Concept
[Figma design and concept](https://www.figma.com/file/HC0kZe2q8kFNpENdfDZvuF/ALP-VP-KEL.8?type=design&node-id=0%3A1&mode=design&t=KiflhSXzXQJ0iDWv-1)

### How to run
- open terminal of the project
- composer install
- cp .env.example .env
- php artisan key:generate
- php artisan serve
- composer require laravel/sanctum
- php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
- php artisan migrate
