# Follow these step for git work-flow

Before Push to gitlab always format it with laravel pint.

```
./vendor/bin/pint
```

### Cloning

* git clone [csfd-url]
* git checkout -b [your-branch]
* git pull origin dev
* 
### Push

* git add .
* git commit -m "[your-commit-message]"
* git push origin [your-branch]
* then go to the gitlab/[csfd-repo] then create pull request and merge it to the dev-branch
