# Deploying Fjoy's POS as an Offline PWA

You have successfully converted your PHP POS into a standalone Progressive Web App (PWA) ready for free hosting on GitHub Pages!

## 1. Commit and Push
Open your terminal and run:

```bash
git add docs
git commit -m "Add PWA files for GitHub Pages deployment"
git push origin main
```
*(If you haven't linked a remote GitHub repo yet, create one on GitHub.com and follow their instructions to push your code)*

## 2. Enable GitHub Pages
1. Go to your repository on **GitHub.com**.
2. Click **Settings** (top tab).
3. On the left sidebar, click **Pages**.
4. Under **Build and deployment** > **Source**, select **Deploy from a branch**.
5. Under **Branch**, select `main` and then select the `/docs` folder (instead of /(root)).
6. Click **Save**.

## 3. Install on Android (Sister's Phone)
1. Wait about 60 seconds for the deploy to finish.
2. The URL will appear at the top of the Pages settings (e.g., `https://yourusername.github.io/FjoysPOS/`).
3. Open this URL in **Chrome** on the Android phone.
4. You should see the POS.
5. Tap the **three-dot menu** (⋮) in Chrome.
6. Tap **"Add to Home Screen"** or **"Install App"**.
7. Confirm cleanly.

## 4. Offline Usage
- Once installed, open the "Fjoy's POS" app from the home screen.
- Turn off WiFi/Data to test.
- It will work perfectly offline!
- Orders are saved on the device.
- Use the **Daily Summary (📊)** feature to track sales.
