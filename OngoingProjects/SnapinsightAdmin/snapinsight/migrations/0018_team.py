# Generated by Django 3.0.8 on 2020-08-06 22:03

from django.db import migrations, models


class Migration(migrations.Migration):

    dependencies = [
        ('snapinsight', '0017_marketing_social'),
    ]

    operations = [
        migrations.CreateModel(
            name='Team',
            fields=[
                ('id', models.AutoField(auto_created=True, primary_key=True, serialize=False, verbose_name='ID')),
                ('name', models.CharField(max_length=500)),
                ('description', models.CharField(max_length=500)),
                ('department', models.CharField(max_length=500)),
                ('positon', models.CharField(max_length=500)),
                ('email', models.CharField(max_length=500)),
                ('talent', models.CharField(max_length=500)),
            ],
        ),
    ]
