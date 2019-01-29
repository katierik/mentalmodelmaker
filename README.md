# mentalmodelmaker
Generates a Mental Model Diagram (based on Indy Young's Mental Models)

Requires a CSV that has the following headers:
- "Mental Space" - The mental space (refer to Mental Models)
- "Task tower" - The task tower (refer to Mental Models)
- "Atomic task" - The atomic task (refer to Mental Models)
- "TID" - A unique ID for each task
- "CleanType" - Role with no asterisks or special charators. In this data, it is "QE, PM, RCM etc". Used for color coding.

The CSV should be organized by Mental Space first, Task Tower second. (An easy way to do this is to sort your spreadsheet from A-Z on the task tower first, and then A-Z on the Mental spaces)

(If mental space or task tower is undefined, it will be put into a general bucket of empty items.)

