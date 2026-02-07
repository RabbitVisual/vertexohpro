from playwright.sync_api import sync_playwright

def run(playwright):
    browser = playwright.chromium.launch(headless=True)
    page = browser.new_page()

    # Login via backdoor
    page.goto("http://127.0.0.1:8000/force-login/1")

    # Wait for dashboard to load
    try:
        page.wait_for_selector('h1:has-text("Painel do Professor")', timeout=10000)
    except:
        print("Dashboard failed to load or login failed")
        page.screenshot(path="error.png")
        browser.close()
        return

    # Check widgets presence
    page.wait_for_selector('div[data-widget="resumo-frequencia"]')
    page.wait_for_selector('div[data-widget="agenda-aulas"]')
    page.wait_for_selector('div[data-widget="atalhos-bncc"]')
    page.wait_for_selector('div[data-widget="marketplace-trends"]')

    # Wait for chart and trends to load (ajax)
    page.wait_for_timeout(3000)

    # Take screenshot
    page.screenshot(path="teacher_panel_dashboard.png")
    print("Screenshot saved to teacher_panel_dashboard.png")

    browser.close()

with sync_playwright() as playwright:
    run(playwright)
