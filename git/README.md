# Point branch develop to HEAD of the master branch

```
git checkout -B develop master
git push -f
```

# Delete branch

```
git branch -d v60
git push --delete origin v60
```
# Check difference between 2 branches

```
git l master..develop --no-merges
```
# Tagging

```
git tag -a v80-release -m "v80 release 2019-02-17: bugfix xxx"
```
