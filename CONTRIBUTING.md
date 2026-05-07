# Contributing to Enix Addons for Elementor

Thank you for your interest in contributing to Enix Addons! This document provides guidelines for contributors.

## Version Control Workflow

### Semantic Versioning
We follow [Semantic Versioning](https://semver.org/):
- **Major (X.0.0):** Breaking changes
- **Minor (X.Y.0):** New features (backward compatible)
- **Patch (X.Y.Z):** Bug fixes (backward compatible)

### Commit Message Format
We use conventional commits:
- `feat:` for new features
- `fix:` for bug fixes
- `docs:` for documentation changes
- `style:` for code style changes
- `refactor:` for code refactoring
- `test:` for adding tests
- `chore:` for maintenance tasks

Example:
```
feat: add weather widget with real-time data
fix: resolve accordion animation issues
docs: update installation instructions
```

### Release Process

1. **Create a feature branch:**
   ```bash
   git checkout -b feature/new-widget
   ```

2. **Make your changes and commit:**
   ```bash
   git add .
   git commit -m "feat: add new widget functionality"
   ```

3. **Push and create pull request**

4. **After merge, create a release:**
   ```bash
   git tag -a v1.3.1 -m "Release version 1.3.1"
   git push origin v1.3.1
   ```

### Automated Releases
When you push a tag (like `v1.3.1`), GitHub Actions will automatically:
- Create a zip file of the plugin
- Generate a GitHub Release
- Attach the zip file to the release

## Development Setup

1. Clone the repository
2. Install dependencies: `composer install`
3. Test your changes thoroughly
4. Follow WordPress coding standards

## Code Standards

- Follow [WordPress Coding Standards](https://developer.wordpress.org/coding-standards/)
- Use proper PHPDoc comments
- Ensure accessibility compliance
- Test with Elementor latest version

Thank you for contributing!
