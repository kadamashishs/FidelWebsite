---
name: webdev-pressnote
description: 'Build and improve static web pages with HTML, CSS, and vanilla JavaScript, then prepare a concise professional press note describing the release. Use for landing pages, responsive layouts, image galleries, navigation fixes, accessibility checks, and website launch updates.'
argument-hint: 'Describe the web change and the press note audience or channel.'
---

# Web Development With Press Note

## When to Use

Use this skill when a request combines frontend implementation with a short announcement, release summary, or press note. It is intended for static HTML/CSS/JavaScript websites and similar lightweight frontend projects.

## Procedure

1. Identify the target page, component, asset, or failing behavior. Read the current implementation and nearby styles before editing.
2. State one local hypothesis about the current behavior and one focused check that can disprove it.
3. Preserve the existing visual language, alignment, public links, and content structure unless the request explicitly changes them.
4. Implement the smallest complete change using the project's existing HTML, CSS, and JavaScript patterns.
5. For responsive work, verify desktop, tablet, and mobile behavior. Check that text fits, images load, controls remain usable, and horizontal scrollers do not hide content.
6. For interactions, test keyboard focus, hover behavior, touch scrolling, reduced-motion behavior, and refresh/deep-link behavior where relevant.
7. Run an executable validation after editing: a focused test, HTML/CSS/JS check, or a local browser smoke test. Do not claim verification that was not performed.
8. Prepare a press note only after the implementation is complete. Keep it factual and concise:
   - Headline: clear benefit or release statement
   - What changed: one short paragraph
   - Key highlights: three to five concrete points
   - User impact: who benefits and how
   - Availability: page, release date, or next action when known
9. Avoid inventing metrics, customers, certifications, quotes, approvals, or launch dates. Mark missing facts as placeholders or ask for them.
10. Report the changed files, validation performed, known limitations, and the final press note separately.

## Quality Criteria

- No broken local asset paths or duplicate IDs.
- Semantic headings and meaningful image alt text.
- Layout remains usable without hover-only essential information.
- Animations pause for interaction and respect `prefers-reduced-motion` when motion is nonessential.
- External image or link dependencies are disclosed when they affect reliability.
- Press-note claims are supported by the implementation or supplied project facts.

## Press Note Template

```text
FOR IMMEDIATE RELEASE

[Headline]

[Organization] announces [specific website update or launch] to help [audience] [clear benefit].

Highlights:
- [Concrete feature or improvement]
- [Concrete feature or improvement]
- [Responsive, accessibility, or performance benefit]

The update is available at [page or URL]. For more information, contact [approved contact].
```

## Output Format

Finish with:

1. Implementation summary
2. Validation summary
3. Press note
4. Open facts or placeholders that need confirmation
