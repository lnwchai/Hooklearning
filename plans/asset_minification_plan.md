# Asset Minification and CSS Cleaning Plan

## Objective
To create an optimized build process for minifying JavaScript and CSS files, and further cleaning CSS for better performance in the WordPress theme.

## Current Setup
- **Build Script**: `build-assets.sh` uses `uglycss` and `uglyjs` (global tools) to minify CSS and JS files.
- **Output**: Minified files are placed in `assets/dist/` with source maps.
- **Package.json**: Includes `clean-css-cli` and `uglify-js` as devDependencies, but not used in scripts.
- **Files**: 
  - CSS: `style-d.css`, `style-m.css`
  - JS: `main.js`, `vimeo.js`, `html2canvas.js`

## Proposed Changes
- Switch to using npm-installed tools (`clean-css-cli` for CSS, `uglify-js` for JS) for consistency and reliability.
- Use `clean-css` for advanced CSS optimization (cleaning) beyond basic minification.
- Update `package.json` scripts and `build-assets.sh` accordingly.
- Ensure source maps are generated.

## Tools Needed
- `clean-css-cli`: For minifying and optimizing CSS.
- `uglify-js`: For minifying JS.
- Update scripts to use these instead of global `uglycss` and `uglyjs`.

## Implementation Steps
1. Update `package.json` scripts to use `clean-css-cli` and `uglify-js`.
2. Modify `build-assets.sh` to call the npm scripts or use the tools directly.
3. Test the build process to ensure minified files are generated correctly.
4. Verify source maps are created.
5. Update documentation if needed.

## Workflow Diagram
```mermaid
graph TD
    A[Start Build] --> B[Create assets/dist directory]
    B --> C[Minify CSS with clean-css-cli]
    C --> D[Minify JS with uglify-js]
    D --> E[Generate Source Maps]
    E --> F[End Build]