# Generated by Django 3.0.8 on 2020-08-06 18:36

from django.db import migrations, models


class Migration(migrations.Migration):

    dependencies = [
        ('snapinsight', '0013_remove_service_roadmap_final_step'),
    ]

    operations = [
        migrations.AddField(
            model_name='service_roadmap',
            name='date',
            field=models.CharField(default='', max_length=500),
        ),
    ]