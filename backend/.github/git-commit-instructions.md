Write a meaningful compact commit message in the conventional commit convention by trying to understand what was the benefits the code author wanted to add by their changes to codebase with this commit.

--------------------------------------
Format (The <type> and <subject> fields are mandatory. The <subject> field starts with uppercase.):
<type>: <subject>
<BLANK LINE>
<body>
--------------------------------------

Only possible types:
- feat (feature): Introduces a new feature or functionality to the codebase.
- fix (bug fix): Resolves a bug or issue in the codebase.
- docs (documentation): Adds or updates documentation.
- style (formatting): Changes code formatting without affecting logic (e.g., fixing whitespace, adding semicolons).
- refactor: Changes the code structure without altering its behavior (e.g., improving code readability, modularization).
- perf (performance): Improves code performance (e.g., optimizing algorithms, reducing resource usage).

Body can be empty when a commit message is self-explanatory from the subject.
Each body line must not be longer than 100 characters.
Each body line must be started with a '-' bullet.
Do not repeat similar content in the body lines; summarize similar changes into a single line.
Do not include unnecessary details that have minimal changes.
Skip changes that are not related to the commit subject.
Do not summarize every partial code change; write only the final key code changes where partial modifications converge.
Do not add any Markdown (`) symbols before or after a commit message.
If branch name includes a ticket number, include it in the commit message subject at the beginning.
